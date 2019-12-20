@extends('layouts.camera')

@section('content')
<style type="text/css">
.page-container {
  left: 0;
  right: 0;
  margin: auto;
  margin-top: 20px;
  width: 100%;
  height: 100%;
  display: inline-flex !important;
}

@media only screen and (max-width : 992px) {
  .page-container {
    padding-left: 0;
    display: flex !important;
  }
}

#navbar {
  position: absolute;
  top: 20px;
  left: 20px;
}

.center-content {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  flex-wrap: wrap;
}

.side-by-side {
  display: flex;
  justify-content: center;
  align-items: center;
}
.side-by-side >* {
  margin: 0 5px;
}

.bold {
  font-weight: bold;
}

.margin-sm {
  margin: 5px;
}

.margin {
  margin: 0px;
  padding: 0px;
}
body {
  margin: 0px;
  padding: 0px;
}

.button-sm {
  padding: 0 10px !important;
}

.pad-sides-sm {
  padding: 0 8px !important;
}

#github-link {
  display: flex !important;
  justify-content: center;
  align-items: center;
  border-bottom: 1px solid;
  margin-bottom: 10px;
}

#overlay, .overlay {
  position: absolute;
  top: 0;
  left: 0;
}

#facesContainer canvas {
  margin: 0 auto;
}

</style>
        <div style="position: relative" class="margin"  style="width: 100%;height: 100%;">
          <video onloadedmetadata="onPlay(this)" id="inputVideo" autoplay muted playsinline style="width: 100%; height: 100%"></video>
          <canvas id="overlay" style="width: 100%; height: 100%"></canvas>
        </div>
        <h2 id="greeting" style="text-align: center;"></h2>

@endsection

@section('footer')
  <script src="{{url('')}}:9000/face-api.js"></script>
  <script src="{{url('')}}:9000/commons.js"></script>
  <script type="text/javascript">

      let minConfidence = 0.5
      let invitation_id = ""

    const classes = [{!!\App\Invitation::select(DB::raw('GROUP_CONCAT(CONCAT("\'",id,"\'")) as data'))->where('event_id',Session::get('event_id'))->where('custom_field_3',1)->first()->data!!}]

    function getFaceImageUri(className, idx) {
      return `/models/${className}/${idx}.png`
    }

    function checkInvitation(id) {
      $.ajax({
          url: "{{route('invitation.check_id')}}", 
          dataType:'json',
          data:{
            id:id,
            _token:'{{csrf_token()}}'
          },
          method:'POST',
          success: function(result){
            $("#greeting").html('Welcome, <br>'+result.result.name+'<br>'+result.result.company)
            invitation_id = ""
        }
      });
    }

    // fetch first image of each class and compute their descriptors
    async function createBbtFaceMatcher(numImagesForTraining = 1) {
      const maxAvailableImagesPerClass = 5
      numImagesForTraining = Math.min(numImagesForTraining, maxAvailableImagesPerClass)

      const labeledFaceDescriptors = await Promise.all(classes.map(
        async className => {
          const descriptors = []
          for (let i = 1; i < (numImagesForTraining + 1); i++) {
            const img = await faceapi.fetchImage(getFaceImageUri(className, i))
            descriptors.push(await faceapi.computeFaceDescriptor(img))
          }

          return new faceapi.LabeledFaceDescriptors(
            className,
            descriptors
          )
        }
      ))

      return new faceapi.FaceMatcher(labeledFaceDescriptors)
    }

    async function onPlay() {
      const videoEl = $('#inputVideo').get(0)
      
      if(videoEl.paused || videoEl.ended)
        return setTimeout(() => onPlay())


      const options = new faceapi.SsdMobilenetv1Options({ minConfidence })

      const ts = Date.now()

      const result = await faceapi.detectAllFaces(videoEl, options)
        .withFaceLandmarks()
        .withFaceDescriptors()

      if (result) {
        console.log(result)
        const canvas = $('#overlay').get(0)
        const dims = faceapi.matchDimensions(canvas, videoEl, true)
        
        const resizedResults = faceapi.resizeResults(result, dims)

        resizedResults.forEach(({ detection, descriptor }) => {
          const label = faceMatcher.findBestMatch(descriptor).toString()
          // const label = 'You'
          const options = { label }
          const drawBox = new faceapi.draw.DrawBox(detection.box, options)
          drawBox.draw(canvas)

          if(invitation_id==""){
            if(!label.includes('unknown')){
              invitation_id = label
              checkInvitation(label)
            }
          }
        })

        // faceapi.draw.drawDetections(canvas, faceapi.resizeResults(result, dims))



      }

      setTimeout(() => onPlay())
    }

    function getCurrentFaceDetectionNet() {
        return faceapi.nets.ssdMobilenetv1
    }

    function isFaceDetectionModelLoaded() {
      return !!getCurrentFaceDetectionNet().params
    }


    async function run() {

      if (!isFaceDetectionModelLoaded()) {
        await getCurrentFaceDetectionNet().load('/models')
      }

      await faceapi.loadFaceLandmarkModel('/models')
      await faceapi.loadFaceRecognitionModel('/models')

      faceMatcher = await createBbtFaceMatcher(1)
      // try to access users webcam and stream the images
      // to the video element
      const stream = await navigator.mediaDevices.getUserMedia({ video: {} })
      const videoEl = $('#inputVideo').get(0)
      videoEl.srcObject = stream
    }

    function updateResults() {}

    $(document).ready(function() {
      run()
    })

  </script>
@endsection
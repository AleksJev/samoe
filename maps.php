<html>
<head>
   <title>Sample</title>
   <script type="text/javascript" src="https://www.google.com/jsapi"> </script>
   <script type="text/javascript">
      var ge;
      google.load("earth", "1");

      function init() {
         google.earth.createInstance('map3d', initCB, failureCB);
      }

      function initCB(instance) {
         ge = instance;
         ge.getWindow().setVisibility(true);
      }

      function failureCB(errorCode) {
      }

      google.setOnLoadCallback(init);
   </script>

</head>
<body>
   <div id="map3d" style="height: 400px; width: 600px;"></div>
</body>
</html>
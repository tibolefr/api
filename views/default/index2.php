<?php 
	$cssAnsScriptFilesModule = array(
	  //l'ordre est a respecter
		'/plugins/swagger-ui/css/typography.css',
	  '/plugins/swagger-ui/css/reset.css',
	  '/plugins/swagger-ui/css/screen.css',
	  '/plugins/swagger-ui/css/reset.css',
	  '/plugins/swagger-ui/css/print.css',
	  '/plugins/swagger-ui/lib/handlebars-2.0.0.js',
	  '/plugins/swagger-ui/lib/underscore-min.js',
	  '/plugins/swagger-ui/lib/backbone-min.js',
	  '/plugins/swagger-ui/swagger-ui.min.js',
	  '/plugins/swagger-ui/lib/highlight.7.3.pack.js',
	  '/plugins/swagger-ui/lib/jsoneditor.min.js',
	  '/plugins/swagger-ui/lib/marked.js',
	  '/plugins/swagger-ui/lib/swagger-oauth.js'


	/*

	<link href='css/typography.css' media='screen' rel='stylesheet' type='text/css'/>
  <link href='css/reset.css' media='screen' rel='stylesheet' type='text/css'/>
  <link href='css/screen.css' media='screen' rel='stylesheet' type='text/css'/>
  <link href='css/reset.css' media='print' rel='stylesheet' type='text/css'/>
  <link href='css/print.css' media='print' rel='stylesheet' type='text/css'/>
	<script src='lib/jquery-1.8.0.min.js' type='text/javascript'></script>
  <script src='lib/jquery.slideto.min.js' type='text/javascript'></script>
  <script src='lib/jquery.wiggle.min.js' type='text/javascript'></script>
  <script src='lib/jquery.ba-bbq.min.js' type='text/javascript'></script>
  <script src='lib/handlebars-2.0.0.js' type='text/javascript'></script>
  <script src='lib/underscore-min.js' type='text/javascript'></script>
  <script src='lib/backbone-min.js' type='text/javascript'></script>
  <script src='swagger-ui.js' type='text/javascript'></script>
  <script src='lib/highlight.7.3.pack.js' type='text/javascript'></script>
  <script src='lib/jsoneditor.min.js' type='text/javascript'></script>
  <script src='lib/marked.js' type='text/javascript'></script>
  <script src='lib/swagger-oauth.js' type='text/javascript'></script>*/

	);
	HtmlHelper::registerCssAndScriptsFiles( $cssAnsScriptFilesModule ,Yii::app()->theme->baseUrl."/assets");
	
?>

<div class="swagger-section">
  <div  id='header'>
    <div class="swagger-ui-wrap">
      <a id="logo" href="http://swagger.io">swagger</a>
      <form id='api_selector'>
        <div class='input'><input placeholder="http://example.com/api" id="input_baseUrl" name="baseUrl" type="text"/></div>
        <div class='input'><input placeholder="api_key" id="input_apiKey" name="apiKey" type="text"/></div>
        <div class='input'><a id="explore" href="#" data-sw-translate>Explore</a></div>
      </form>
    </div>
  </div>
</div>

<div id="message-bar" class="swagger-ui-wrap" data-sw-translate>&nbsp;</div>
<div id="swagger-ui-container" class="swagger-ui-wrap"></div>
<script type="text/javascript">

	var baseUrl2 = "<?php echo Yii::app()->theme->baseUrl ; ?>"
    $(function () {
      var url = window.location.search.match(/url=([^&]+)/);
      if (url && url.length > 1) {
        url = decodeURIComponent(url[1]);
      } else {
        url = "https://127.0.0.1:80/html/workspaceWeb/test/swagger-ui-2.1.4/test/specs/v1.2/petstore/api.json";
      }

      // Pre load translate...
      if(window.SwaggerTranslator) {
        window.SwaggerTranslator.translate();
      }
      window.swaggerUi = new SwaggerUi({
        url: url,
        dom_id: "swagger-ui-container",
        supportedSubmitMethods: ['get', 'post', 'put', 'delete', 'patch'],
        onComplete: function(swaggerApi, swaggerUi){
          if(typeof initOAuth == "function") {
            initOAuth({
              clientId: "your-client-id",
              clientSecret: "your-client-secret-if-required",
              realm: "your-realms",
              appName: "your-app-name", 
              scopeSeparator: ",",
              additionalQueryStringParams: {}
            });
          }

          if(window.SwaggerTranslator) {
            window.SwaggerTranslator.translate();
          }

          $('pre code').each(function(i, e) {
            hljs.highlightBlock(e)
          });

          addApiKeyAuthorization();
        },
        onFailure: function(data) {
          log("Unable to Load SwaggerUI");
        },
        docExpansion: "none",
        jsonEditor: true,
        apisSorter: "alpha",
        defaultModelRendering: 'schema',
        showRequestHeaders: true
      });

      function addApiKeyAuthorization(){
        var key = encodeURIComponent($('#input_apiKey')[0].value);
        if(key && key.trim() != "") {
            var apiKeyAuth = new SwaggerClient.ApiKeyAuthorization("api_key", key, "query");
            window.swaggerUi.api.clientAuthorizations.add("api_key", apiKeyAuth);
            log("added key " + key);
        }
      }

      $('#input_apiKey').change(addApiKeyAuthorization);

      // if you have an apiKey you would like to pre-populate on the page for demonstration purposes...
      /*
        var apiKey = "myApiKeyXXXX123456789";
        $('#input_apiKey').val(apiKey);
      */

      window.swaggerUi.load();

      function log() {
        if ('console' in window) {
          console.log.apply(console, arguments);
        }
      }
  });
  </script>
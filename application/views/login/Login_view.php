<?php 

/**
 * @author Tony Frezza

 */


?>
<body dir="ltr">
    <main class="main">
        <div class="row">
          <div class="content">
            <div class="col-md-5 vamiddle" style="padding-top: 74.25px;">
              <div class="card-group card-inverse">
                <div id="lcard" class="card" style="background-color: white;">
                  <div class="card-block">
                    <center>
                      <h1>
                        <img src="<?php echo BASE_URL;?>assets/img/logo-dark.png" width="200px">
                      </h1>
                    </center><br>
                    <form action="<?php echo BASE_URL;?>" class="form-login" method="post" accept-charset="utf-8" >
                    <input type="hidden" value="dologin" name="dologin" />
                    <div class="row-fluidd">
                      <div class="input-group margin-bottom-1">
                        <span class="input-group-addon"><i class="la la-user"></i> </span>
                        <input type="text" name="username" value="" id="identity" class="form-control">
                      </div>
                      <div class="input-group margin-bottom-2">
                        <span class="input-group-addon"><span class="arrow"></span><i class="la la-lock"></i> </span>
                        <input type="password" name="password" value="" id="password" class="form-control">
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-xs-12">
                        <a href="" class="btn btn-link text-white p-x-0">
                          <!--Esqueceu a senha? -->
                        </a>
                      </div>
                      <div class="col-xs-12 text-xs-right margin-top-10">
                        <input type="submit" name="submit" value="Acessar" class="btn btn-secondary btn-login"/>
                      </div>
                    </div>
                    </form>                              
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>
      
      
        <script type="text/javascript">
            $(document).ready(function() {
                
                $('#page_loading').hide();
                
                $('.btn-login').bind('click',function(e){
                   $('#page_loading').show()
                });
                
            });
        </script>
      
      <div class="loading-backdrop" id="page_loading" style="display: block;"></div>  
    </main>
</body>
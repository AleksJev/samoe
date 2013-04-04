<div class="content">
    <div class="in_main">
        <div class="regform">
            <fieldset>
                <legend><h2>Регистрация</h2></legend>
                <?=form_open(base_url().'users/register');?>
                <?php
                    $user     = array('name'  => 'user',
                                      'id'    => 'user',
                                      'value' => set_value('user'));
                    $password = array('name'  => 'password',
                                      'id'    => 'password',
                                      'value' => "");
                    $passconf = array('name'  => 'passconf',
                                      'id'    => 'passconf',
                                      'value' => "");
                    $name     = array('name'  => 'name',
                                      'id'    => 'name',
                                      'value' => set_value('name'));
                    $sname    = array('name'  => 'sname',
                                      'id'    => 'sname',
                                      'value' => set_value('sname'));
                    $bday     = array('name'  => 'bday',
                                      'id'    => 'datepicker',
                                      'value' => set_value('bday'));
                    $email    = array('name'  => 'email',
                                      'id'    => 'email',
                                      'value' => set_value('email'));
                    ?>
                    <script>
                    $(document).ready(function()
                        {
                            var pass = $('#password').val('8');
                            var passconf = $('#passconf').val();
                            var pcf = $('#passconf');

                            function checkPASS()
                            {
                                var lowpass = /^[A-Za-z]+$/;
                                var middlepass = /^[0-9a-zA-Z_]{6,40}$/;
                                var strongpass = /^[A-Za-z0-9_]+[0-9]+\W+$/;
                                //var pass = document.getElementById("password").value;
                                var password = document.getElementById("password");
                                var pass_text = document.getElementById('pass_text');

                                if(strongpass.test(pass) == true)
                                {
                                    pass_text.innerHTML = "strong pass";
                                    password.style.border = "3px solid #0F0";
                                }
                                else if(middlepass.test(pass) == true)
                                {
                                    pass_text.innerHTML = "middle pass";
                                    password.style.border = "3px solid #FF0";
                                }
                                else if(lowpass.test(pass) == true)
                                {
                                    pass_text.innerHTML = "low pass";
                                    password.getElementById("pass").style.border = "3px solid #F0F";
                                }
                                else
                                {
                                    //document.getElementById("pass_text").innerHTML = "enter pass";
                                    pass_text.text('ENTER PASSWORD');
                                    password.style.border = "3px solid #F0F";
                                }
                            }


                            document.getElementById("password").onkeyup = function()
                            {
                                checkPASS();
                            }

                            $('#passconf').on('click',function() {
                                console.log('passconf')

                            })


                            $('#datepicker').datepicker({
                                changeMonth: true,
                                changeYear: true
                            });
                        });



                    </script>            
                <label>Логин</label>
                <div>
                    <?=form_input($user);?>
                </div>
                <label>Пароль</label>
                <div>
                <div id="pass_text"></div>
                    <?=form_password($password);?>
                </div>
                <label>Повтор пароля</label>
                <div>
                    <?=form_password($passconf);?>
                </div>
                <label>Имя</label>
                <div>
                    <?=form_input($name);?>
                </div>
                <label>Фамилия</label>
                <div>
                    <?=form_input($sname);?>
                </div>
                <label>Дата рождения</label>
                <div>
                    <?=form_input($bday);?>
                </div>
                <label>Email</label>
                <div>
                    <?=form_input($email);?>
                </div>
                <input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR'];?>"/>
                <div>
                    <?=form_submit(array('name'=>'register'),'Register');?>
                </div>
                <div>
                    <?php $val=validation_errors();?>
                </div>
                <?=form_close();?>
                <?php if (empty($val))
                {
                    //echo 'empty';
                }
                else
                {
                    ?>
                    <script>
                        $(window).ready(function() {

                            //$( ".selector" ).datepicker({ changeYear: true });

                            $.fx.speeds._default = 1000;
                                $(function() {
                                    $( "#reg_errors" ).dialog({
                                        autoOpen: true,
                                        show: "blind",
                                        minWidth: 500,
                                        /*modal:true,*/
                                        hide: "explode"
                                    });
                                });


                        })
                    </script>

                    <div id="reg_errors" title="Ошибки вот такие">
                        <p><?=validation_errors();?></p>
                    </div>
                    <?
                    
                }
                ?>
            </fieldset>
        </div>
    </div>
</div>
<?php
class Captcha_lib
{
    public function captcha_actions()
    {
        $CI =& get_instance();
        $CI -> load -> helper('captcha');
        //загружаем хелпер для генерирования случайной строки
        $CI -> load -> helper('string');
        $rnd_str = random_string('numeric',5);
        // записываем строку в сессию
        $ses_data = array();
        $ses_data['rnd_captcha'] = $rnd_str;
        $CI -> session -> set_userdata($ses_data);
        // параметры картинки
        $settings = array('word'      => $rnd_str,
                          'img_path'   => './images/captcha/',
                          'img_url'    => base_url().'images/captcha/',
                          'font_path'  => './system/fonts/cour.ttf',  // 'font_path'  => './system/fonts/pixelshift.ttf',
                          'img_width'  => 120,
                          'img_height' => 30,
                          'expiration' =>60); // через скока сек уничтожаются капчи сгенерированные
        // создаем капчу
        $captcha = create_captcha($settings);
        // получаем переменную код картинки
        $imgcode = $captcha['image'];
        return $imgcode;
    }
}
?>
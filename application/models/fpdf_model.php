<?php
class Fpdf_model
{
   
    function get_article($art_id)
    {
        require_once('/FPDF/fpdf.php');
        $q="SELECT * FROM `articles` WHERE `art_id`='$art_id'";
        $res = $this->db->query($q);
        //$record = mysql_fetch_assoc($q);
        
        $pdf=new FPDF();
        $pdf->AddFont('test1','','/FPDF/MyRussionFont/test1.php');
        $pdf->AddPage();
        $pdf->SetFont('test1','',16);
        $pdf->Cell(10,10,'Hello ');
        //$pdf->SetFillColor(100,120,155);
        //$pdf->Cell(20,50,'webskola!');
        //$pdf->Cell(-40,30,'02.02.2012.');
        $pdf->Output();
        
        //http://www.uamedwed.com/web/fpdf-biblioteka-dlja-sozdanija-pdf-fajlov-na-php.htm
        //http://www.google.lv/url?sa=t&rct=j&q=fpdf16%20%D0%BF%D1%80%D0%B8%D0%BC%D0%B5%D1%80%D1%8B&source=web&cd=3&ved=0CDAQFjAC&url=http%3A%2F%2Fclients.webtec.com.ua%2Ftest%2Ffpdf16%2F%25D1%25EE%25E7%25E4%25E0%25ED%25E8%25E5%2520PDF.doc&ei=4G8qT9PYFcHdtAaDnrD5DA&usg=AFQjCNGroWV2n1VACExROVwH-VuG3MYHzg

    }

}


?>
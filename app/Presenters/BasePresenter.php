<?php

namespace App\Presenters;

use Robbo\Presenter\Presenter;
use Carbon\Carbon;
use DinImage;

abstract class BasePresenter extends Presenter {


    /**
     * Decorator link Menu
     * @return string
     */
    public function presentLink()
    {
        if($this->url)
        {
            return $this->url;
        }

        return $this->uri;
    }

    /**
     * Decorator link complete uri
     * @return string
     */
    public function presentCompleteUri()
    {
        return getenv('APPLICATION_URL').$this->uri;
    }

    /**
     * Decorator short link
     * @return string
     */
    public function presentShortUrl()
    {
        return getenv('APPLICATION_URL').$this->uri;
    }


     /**
     * Format date
     * @param type $date
     * @param string $formatPresenter
     * @return type
     */
    public function presentDateFormat($date = null , $formatPresenter = 'd/m/Y')
    {
        if(!$date){
            $date = $this->date;
        }
        $dateCarbon = new Carbon($date);
        return $dateCarbon->format($formatPresenter);
    }

     /**
     * Format data hora
     * @param type $date
     * @param string $formatPresenter
     * @return string
     */
    public function presentUpdateDataWithHour($date = null , $formatPresenter = 'd/m/Y - H:i')
    {
        if(!$date){
            $date = $this->upd_date;
        }
        $dateCarbon = new Carbon($date);
        return $dateCarbon->format($formatPresenter);
    }

     /**
     * Format data in weekday
     * @param string $date
     * @param string $formatPresenter
     * @return string
     */
    public function presentWeekDay($date = null)
    {
        if(!$date){
            $date = $this->date;
        }
        $dateCarbon = new Carbon($date);

        switch (  $dateCarbon->dayOfWeek ) {
          case '1':
            return "Segunda-Feira" ;
            break;

          case '2':
            return  "Terça-Feira";
            break;

          case '3':
            return  "Quarta-Feira";
            break;

          case '4':
            return  "Quinta-Feira";
            break;

          case '5':
            return "Sexta-Feira";
            break;

          case '6':
            return "Sábado";
            break;

          case '7':
            return "Domingo";
            break;

          default:
            return "";
            break;
        }
    }

    /**
     * Decorator url
     * @return string
     */
    public function presentUrlShare()
    {
        return request()->url();
    }


    /**
    * Decorator description com quebra de linha
    * @return string
    */
     public function presentLimitCharacter($field, $sizeMaximum, $sizeStart = 0 )
     {
          if(mb_strlen($field) <= $sizeMaximum)
          {
              return $field;
          }

          $string = substr($field, $sizeStart, $sizeMaximum - 3 );
          return  $string."...";
     }


    /**
   * Decorator do mês
   * @return type
   */
  protected function presentMonth($month)
  {
      switch ($month)
      {
        case 1:
            $month = "Janeiro";
            break;
        case 2:
            $month = "Fevereiro";
            break;
        case 3:
            $month = "Março";
            break;
        case 4:
            $month = "Abril";
            break;
        case 5:
            $month = "Maio";
            break;
        case 6:
            $month = "Junho";
            break;
        case 7:
            $month = "Julho";
            break;
        case 8:
            $month = "Agosto";
            break;
        case 9:
            $month = "Setembro";
            break;
        case 10:
            $month = "Outubro";
            break;
        case 11:
            $month = "Novembro";
            break;
        case 12:
            $month = "Dezembro";
            break;
      }

    return $month;

  }

  /**
  * Decora a imagem da metatag
  **/
  public function presentCoverToMetatag()
  {
     $image =  DinImage::setWidth(1000)
                    ->setHeight(1000)
                    ->setName($this->title)
                    ->setCommand('widen')
                    ->setImage($this->cover)
                    ->render();

      return asset($image);
  }

  /**
   * Default campo content
   * OBs.: não é possivel passar parâmetro pela view
   * @param string $field
   * @return string
   */
  public function presentCkContent($field = 'content')
  {
      $content = $this->$field;

      if (!$content)
          return '';

      $doc = new \DOMDocument();
      $us_ascii = @mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8');
      $doc->loadHTML(@$us_ascii);

      $links = $doc->getElementsByTagName('a');

      foreach ($links as $link) {
          $arrLink = explode('/', $link->getAttribute('href'));
          if (count($arrLink) && count($arrLink) > 1 && $arrLink[1] == 'system') {
              $arrLink[0] = getenv('ADMIN_URL');
              $link->setAttribute('href', implode('/', $arrLink));
              $doc->saveHTML($link);
          }
      }

      $images = $doc->getElementsByTagName('img');

      foreach ($images as $image) {

          $src = $image->getAttribute('src');

          if (substr($src, 0, 1) == '/') {

              $width = null;
              $height = null;

              $src = $image->getAttribute('src');
              $alt = $image->getAttribute('alt');

              preg_match('/width:(\d+)(px)?/', $image->getAttribute('style'), $matches);
              if (count($matches)) {
                  $width = intval($matches[1]);
              }

              preg_match('/height:(\d+)(px)?/', $image->getAttribute('style'), $matches);
              if (count($matches)) {
                  $height = intval($matches[1]);
              }

              if (!is_null($width) && !is_null($height)) {

                  $resized = DinImage::setWidth($width)
                                     ->setHeight($height)
                                     ->setName($alt)
                                     ->setCommand('fit')
                                     ->setImage($src)
                                     ->render();

                  $image->setAttribute('alt', $alt);
                  $image->setAttribute('src', $resized);

                  $Zoom = $doc->createElement('a');
                  $Zoom->setAttribute('class', 'has-subtitle img');
                  $Zoom->setAttribute('href', getenv('ADMIN_URL') . $src);
                  $Zoom->setAttribute('data-lightbox', 'lightbox');
                  $Zoom->setAttribute('data-title', $alt);
                  $Zoom->setAttribute('style', $image->getAttribute('style'));
                  $Zoom->setAttribute('title', $alt);

                  $image->parentNode->replaceChild($Zoom, $image);
                  $Zoom->appendChild($image);

                  $doc->saveHTML($Zoom);
              }
          }
      }
      return preg_replace('~<(?:!DOCTYPE|/?(?:html|body))[^>]*>\s*~i', '', $doc->saveHTML());
  }


  /**
  * Decorator description com quebra de linha
  * @return string
  */
   public function presentDescriptionWithBreak()
   {
       return nl2br($this->description);
   }


}

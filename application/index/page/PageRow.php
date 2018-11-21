<?php
namespace app\index\page;

use think\Paginator;
class PageRow extends Paginator
{
    public function render()
    {
        $html='<div id="wrapper" class="contentleft jyd_n18_fot swiper-free-mode">
				<ul class="leftlist" style="">';
        for ($i=1;$i<=$this->lastPage;$i++){
            if($i==$this->currentPage){
                $html.='<li class="wps_item wps_active"><a class="liston" href="javascript:;">'.$i.'排</a></li>';
            }else{
                $html.='<li class="wps_item"><a href="'.$this->url($i).'">'.$i.'排</a></li>';
            }
        }
        $html.="</ul></div>";
        return $html;
    }
}

?>
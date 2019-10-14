<?php
/**
 * Created by Eric-Nothing.
 * Date: 2019/10/8
 * Time: 14:08
 */

namespace App\Admin\Extensions\Forms;


use Encore\Admin\Form\Field;

class ShopOrderShip extends Field
{
    protected $view = "admin.activity_order_agree_refund";


    public function __construct(string $column = '', array $arguments = [])
    {
        parent::__construct($column, $arguments);
    }

    public function render()
    {

        $id = $this->form->model()->id;
        $token = csrf_token();
        $this->variables = [
            'status'=>$this->form->model()->status
        ];

        $this->script = <<<EOT

          $("#agree_ship").click(function () {
          
                var express_id = $("select[name='express_id']").val();
                var delivery_n = $("input[name='delivery_n']").val();
          
                $.post('/admin/api/shop_order_agree_refund',{id:"{$id}",express_id:express_id,,delivery_n:delivery_n,_token:"{$token}"},function(res){
                        console.log(res)
//                    if(res.code == 200){
//                        alert(res.msg);
////                        window.location.reload();
//                    }
//                    alert(res.msg);
                })

          })
          
EOT;

        return parent::render();
    }

}
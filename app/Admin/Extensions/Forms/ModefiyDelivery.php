<?php
/**
 * Created by Eric-Nothing.
 * Date: 2019/10/8
 * Time: 14:08
 */

namespace App\Admin\Extensions\Forms;


use Encore\Admin\Form\Field;

class ModefiyDelivery extends Field
{
    protected $view = "admin.modefiy_delivery";


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

          $("#modefiy_delivery").click(function () {
          
                var express_id = $('select[name="shop_order_delivery[express_id]"]').val();
                var delivery_n = $("#shop_order_delivery_delivery_n").val();
          
                $.post('/admin/api/modify_delivery',{id:"{$id}",express_id:express_id,delivery_n:delivery_n,_token:"{$token}"},function(res){
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
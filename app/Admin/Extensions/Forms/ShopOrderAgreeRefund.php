<?php
/**
 * Created by Eric-Nothing.
 * Date: 2019/10/8
 * Time: 14:08
 */

namespace App\Admin\Extensions\Forms;


use Encore\Admin\Form\Field;

class ShopOrderAgreeRefund extends Field
{
    protected $view = "admin.shop_order_agree_refund";


    public function __construct(string $column = '', array $arguments = [])
    {
        parent::__construct($column, $arguments);
    }

    public function render()
    {

        $id = $this->form->model()->id;
        $token = csrf_token();
        $this->variables = [
            'status'=>$this->form->model()->status,
            'r_type'=>$this->form->model()->r_type
        ];

        $this->script = <<<EOT

          $("#agree_refund").click(function () {
          
                var r_way = $("input[name='r_way']").val();
                $.post('/admin/api/shop_order_agree_refund',{id:"{$id}",r_way:r_way,_token:"{$token}"},function(res){
                    if(res.code == 200){
                        alert(res.msg);
                        window.location.reload();
                    }
                    alert(res.msg);
                })

          })

          $("#pass_refund").click(function () {
          
                $.post('/admin/api/shop_order_pass_refund',{id:"{$id}",_token:"{$token}"},function(res){
                    if(res.code == 200){
                        alert(res.msg);
                        window.location.reload();
                    }
                    alert(res.msg);
                })

          })

          $("#reject_refund").click(function () {
          
                var reply_reason = $("textarea[name='reply_reason']").val();
                console.log(reply_reason)
                $.post('/admin/api/shop_order_reject_refund',{id:"{$id}",reply_reason:reply_reason,_token:"{$token}"},function(res){
                    if(res.code == 200){
                        alert(res.msg);
                        window.location.reload();
                    }
                    alert(res.msg);
                })

          })
          $("#finish_refund").click(function () {
          
                var reply_reason = $("textarea[name='reply_reason']").val();
                console.log(reply_reason)
                $.post('/admin/api/shop_order_finish_refund',{id:"{$id}",_token:"{$token}"},function(res){
                    if(res.code == 200){
                        alert(res.msg);
                        window.location.reload();
                    }
                    alert(res.msg);
                })

          })

EOT;

        return parent::render();
    }

}

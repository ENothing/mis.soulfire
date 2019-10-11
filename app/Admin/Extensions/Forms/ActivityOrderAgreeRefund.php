<?php
/**
 * Created by Eric-Nothing.
 * Date: 2019/10/8
 * Time: 14:08
 */

namespace App\Admin\Extensions\Forms;


use Encore\Admin\Form\Field;

class ActivityOrderAgreeRefund extends Field
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

          $("#agree_refund").click(function () {
          
          
                $.post('/admin/api/activity_order_agree_refund',{id:"{$id}",_token:"{$token}"},function(res){
                
                    console.log(res)
                })

          })

          $("#reject_refund").click(function () {
          
                var reply_reason = $("textarea[name='reply_reason']").val();
                console.log(reply_reason)
                $.post('/admin/api/activity_order_reject_refund',{id:"{$id}",reply_reason:reply_reason,_token:"{$token}"},function(res){
                
                
                    console.log(res)
                })

          })


EOT;

        return parent::render();
    }

}
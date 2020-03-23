@if ($status == 0)
    <div class="box-footer">
        <div class="col-md-2">
        </div>
        <div class="col-md-4">
            <div class="btn-group pull-left">
                <button type="button" class="btn btn-success" id="agree_refund">同意退款</button>
            </div>
            <div class="col-md-2">
            </div>
            <div class="btn-group pull-left">
                <button type="button" class="btn btn-primary" id="reject_refund">驳回</button>
            </div>
        </div>
    </div>
@endif
@if ($status == 2)
    <div class="box-footer">
        <div class="col-md-2">
        </div>
        <div class="col-md-4">
            <div class="btn-group pull-left">
                <button type="button" class="btn btn-info" id="finish_refund">完成退款</button>
            </div>
        </div>
    </div>
@endif
@if ($status == 4)
    <div class="box-footer">
        <div class="col-md-2">
        </div>
        <div class="col-md-4">
            <div class="btn-group pull-left">
                <button type="button" class="btn btn-success" id="reagree_refund">重新同意退款</button>
            </div>
        </div>
    </div>
@endif

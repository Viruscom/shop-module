<div class="modal " id="panoramaModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"><span aria-hidden="true">×</span></button>
            </div>

            <div class="modal-body">
                <iframe frameborder="0" src="https://www.google.com/maps/d/embed?mid=1qm6tBXydm9a-4ruzX9C6iQf6P_o4yMI&ehbc=2E312F" ></iframe>
            </div>
        </div>
    </div>
</div>
<script>
    ;(function($, window, document, undefined) {
        const $doc = $(document);
        const triggerModalBtn = $('.btn-zones');
        const modalTarget = $('.modal');
        const modalCloseBtn = $('.modal .close');

        $doc.ready(function() {
            modalActions();
        });

        function modalActions() {
            triggerModalBtn.on('click', function(e) {
                e.preventDefault();

                modalTarget.addClass('fade-in');
            });

            modalCloseBtn.on('click', function() {
                modalTarget.removeClass('fade-in');
            });
        }
    })(jQuery, window, document);
</script>

<style>

    .modal-body > * {
        height: 600px;
        width: 100%;
    }

    .modal-visible {
        overflow: hidden;
    }

    button.close{
        padding:0;
        cursor:pointer;
        background:0 0;
        border:0;
        -webkit-appearance:none;
    }

    .fade {
        opacity: 0;
        -webkit-transition: opacity .15s linear;
        -o-transition: opacity .15s linear;
        transition: opacity .15s linear;
    }

    .fade.in {
        opacity: 1;
    }

    .modal-open{
        overflow:hidden;
    }

    .modal{
        overflow:hidden;
        position:fixed;
        top:0;
        right:0;
        bottom:0;
        left:0;
        -webkit-overflow-scrolling:touch;
        outline:0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 600;
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.2s ease;
    }


    .modal.fade-in {
        opacity: 1;
        visibility: visible;
    }

    .modal .modal-dialog {
        position: absolute;
        left: 0%;
        top: 0%;
        -webkit-transform: translate(0,0);
        -ms-transform: translate(0,0);
        -o-transform: translate(0,0);
        transform: translate(0,0);
    }

    .modal.fade-in .modal-dialog {
        left: 50%;
        top: 50%;
        -webkit-transform:translate(-50%,-50%);
        -ms-transform:translate(-50%,-50%);
        -o-transform:translate(-50%,-50%);
        transform:translate(-50%,-50%)
    }

    .modal-dialog{
        transition: all 0.2s ease;
    }

    .modal-content{
        position:relative;
        background-color:#fff;
        border:1px solid #999;
        border:1px solid rgba(0,0,0,.2);
        border-radius:0;
        -webkit-box-shadow:0 3px 9px rgba(0,0,0,.5);
        box-shadow:0 3px 9px rgba(0,0,0,.5);
        -webkit-background-clip:padding-box;
        background-clip:padding-box;
        outline:0;
    }
    .modal-backdrop{
        position:fixed;
        top:0;
        right:0;
        bottom:0;
        left:0;
        z-index:1040;
        background-color:#000;
    }
    .modal-backdrop.fade{
        opacity:0;
        filter:alpha(opacity=0);
    }
    .modal-backdrop.in{
        opacity:.5;
        filter:alpha(opacity=50);
    }
    .modal-header{
        padding: 0 15px;
        text-align: right;
    }

    .modal-header .close{
        display: inline-block;
        font-size: 40px;
    }

    .modal-title{
        margin:0;
        line-height:1.3333333;
    }
    .modal-body{
        position:relative;
        padding:15px;
    }
    .modal-footer{
        padding:15px;
        text-align:right;
        border-top:1px solid #e5e5e5;
    }
    .modal-footer .btn+.btn{
        margin-left:5px;
        margin-bottom:0;
    }
    .modal-footer .btn-group .btn+.btn{
        margin-left:-1px;
    }
    .modal-footer .btn-block+.btn-block{
        margin-left:0;
    }
    .modal-scrollbar-measure{
        position:absolute;
        top:-9999px;
        width:50px;
        height:50px;
        overflow:scroll;
    }
    @media (min-width:768px){
        .modal-dialog{
            width:600px;
            margin:30px auto;
        }
        .modal-content{
            -webkit-box-shadow:0 5px 15px rgba(0,0,0,.5);
            box-shadow:0 5px 15px rgba(0,0,0,.5);
        }
        .modal-sm{
            width:300px;
        }
    }

    @media (min-width: 992px) {
        .modal-lg {
            width: 900px;
        }
    }

    @media (max-width: 767px){
        .modal-dialog{
            width: 90vw;
            max-height: 90vh;
        }
        .modal-content{
            -webkit-box-shadow:0 5px 15px rgba(0,0,0,.5);
            box-shadow:0 5px 15px rgba(0,0,0,.5);
        }

        .modal-body > * {
            width: 100%;
            height: 70vh;
        }

    }
</style>

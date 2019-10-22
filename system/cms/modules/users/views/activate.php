<div id="main-container">
    <div class="container p-t-3">
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="rockoflf-ultra text-xs-center">Akun anda telah aktif</h2>
                    <p class="text-xs-center lead">Selamat! Akun Anda telah diaktifkan. Yuk mulai jelajahi Parenting Club.</p>
                </div>
                <div class="row m-x-0 text-xs-center action">
                    <a href="{{url:site}}" class="btn btn-red round">Homepage</a>
                    <a href="{{url:site uri='smart-strength-finder'}}" class="btn btn-red round">Smart Strength Finder</a>
                    <a href="{{url:site uri='dashboard'}}" class="btn btn-red round">Voucher</a>
                    <?php
                        if($this->session->userdata('last_step')>1){
                            echo '<a href="{{url:site uri=\'smart-strength-finder/assessment-tool\'}}" class="btn btn-red round">Lanjutkan Tes Kepintaran</a>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($this->session->flashdata('source') != NULL)  : ?>
<script type="text/javascript">
    $(document).ready(function() {
        ga('send', 'event', 'acquisition', ' activation', "<?=$this->session->flashdata('source')?>");
    });
</script>
<?php endif; ?>
<?php
include_once("../helper/connection.php");
include_once("../helper/function.php");
include_once("../lang/default.php");

cekLogin();

$username = $_SESSION['username'];
$sender = getSingleValDB("device", "pemilik", "$username", "nomor");
$apikey = getSingleValDB("account", "username", "$username", "api_key");
$number = "34644975414";
$message = "Testing%20send%20message%20from:%20" . $username . "%20" . $sender;
$mediaurl = "https://file-examples-com.github.io/uploads/2017/10/file_example_JPG_100kB.jpg";

require_once('../templates/header.php');
?>


<!-- DataTales Example -->
<div class="card shadow mb-4 ml-4 mr-4">
<div class="card-body">
<div class="code-block">
<h3>PHP API CODE Send Text Message (GET)</h3>
<!-- HTML generated using highlightmycode -->
<div style="background: #ffffff; overflow:auto;width:auto;border:solid gray;border-width:.1em .1em .1em .8em;padding:.2em .6em;"><pre style="margin: 0; line-height: 125%"><span style="color: #507090">&lt;?php</span>

<span style="color: #906030">$response</span> <span style="color: #303030">=</span> <span style="color: #008000; font-weight: bold">file_get_contents</span>("<?= $base_url; ?>api/send-message.php?sender=<span style="background-color: #fff0f0"><?= $sender; ?></span>&number=<span style="background-color: #fff0f0"><?= $number; ?></span>&message=<span style="background-color: #fff0f0"><?= $message; ?></span>&api_key=<span style="background-color: #fff0f0"><?= $apikey; ?></span>");

<span style="color: #008000; font-weight: bold">echo</span> <span style="color: #906030">$response</span>;
</pre></div>
<br><br>

<h3>PHP API CODE Send Text Message (POST)</h3>
<!-- HTML generated using highlightmycode -->
<div style="background: #ffffff; overflow:auto;width:auto;border:solid gray;border-width:.1em .1em .1em .8em;padding:.2em .6em;"><pre style="margin: 0; line-height: 125%"><span style="color: #507090">&lt;?php</span>

<span style="color: #906030">$data</span> <span style="color: #303030">=</span> [
    <span style="background-color: #fff0f0">&#39;api_key&#39;</span> <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;<?= $apikey; ?>&#39;</span>,
    <span style="background-color: #fff0f0">&#39;sender&#39;</span>  <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;<?= $sender; ?>&#39;</span>,
    <span style="background-color: #fff0f0">&#39;number&#39;</span>  <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;<?= $number; ?>&#39;</span>,
    <span style="background-color: #fff0f0">&#39;message&#39;</span> <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;<?= $message; ?>&#39;</span>
];

<span style="color: #906030">$curl</span> <span style="color: #303030">=</span> <span style="color: #007020">curl_init</span>();
curl_setopt_array(<span style="color: #906030">$curl</span>, <span style="color: #008000; font-weight: bold">array</span>(
  CURLOPT_URL <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&quot;<?= $base_url;?>api/send-message.php&quot;</span>,
  CURLOPT_RETURNTRANSFER <span style="color: #303030">=&gt;</span> <span style="color: #008000; font-weight: bold">true</span>,
  CURLOPT_ENCODING <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&quot;&quot;</span>,
  CURLOPT_MAXREDIRS <span style="color: #303030">=&gt;</span> <span style="color: #0000D0; font-weight: bold">10</span>,
  CURLOPT_TIMEOUT <span style="color: #303030">=&gt;</span> <span style="color: #0000D0; font-weight: bold">0</span>,
  CURLOPT_FOLLOWLOCATION <span style="color: #303030">=&gt;</span> <span style="color: #008000; font-weight: bold">true</span>,
  CURLOPT_HTTP_VERSION <span style="color: #303030">=&gt;</span> CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&quot;POST&quot;</span>,
  CURLOPT_POSTFIELDS <span style="color: #303030">=&gt;</span> json_encode(<span style="color: #906030">$data</span>))
);

<span style="color: #906030">$response</span> <span style="color: #303030">=</span> <span style="color: #007020">curl_exec</span>(<span style="color: #906030">$curl</span>);

<span style="color: #007020">curl_close</span>(<span style="color: #906030">$curl</span>);
<span style="color: #008000; font-weight: bold">echo</span> <span style="color: #906030">$response</span>;
</pre></div>


<br><br>

<h3>PHP API CODE Send Media Message (GET)</h3>
<!-- HTML generated using highlightmycode -->
<div style="background: #ffffff; overflow:auto;width:auto;border:solid gray;border-width:.1em .1em .1em .8em;padding:.2em .6em;"><pre style="margin: 0; line-height: 125%"><span style="color: #507090">&lt;?php</span>

<span style="color: #906030">$response</span> <span style="color: #303030">=</span> <span style="color: #008000; font-weight: bold">file_get_contents</span>("<?= $base_url;?>api/send-media.php?sender=<span style="background-color: #fff0f0"><?= $sender; ?></span>&number=<span style="background-color: #fff0f0"><?= $number; ?></span>&message=<span style="background-color: #fff0f0"><?= $message; ?></span>&api_key=<span style="background-color: #fff0f0"><?= $apikey; ?></span>&url=<span style="background-color: #fff0f0"><?= $mediaurl; ?></span>&filetype=<span style="background-color: #fff0f0">jpg</span>");

<span style="color: #008000; font-weight: bold">echo</span> <span style="color: #906030">$response</span>;
</pre></div>
<br><br>

<h3>PHP API CODE Send Media Message (POST)</h3>
<!-- HTML generated using highlightmycode -->
<div style="background: #ffffff; overflow:auto;width:auto;border:solid gray;border-width:.1em .1em .1em .8em;padding:.2em .6em;"><pre style="margin: 0; line-height: 125%"><span style="color: #507090">&lt;?php</span>

<span style="color: #906030">$data</span> <span style="color: #303030">=</span> [
    <span style="background-color: #fff0f0">&#39;api_key&#39;</span> <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;<?= $apikey; ?>&#39;</span>,
    <span style="background-color: #fff0f0">&#39;sender&#39;</span>  <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;<?= $sender; ?>&#39;</span>,
    <span style="background-color: #fff0f0">&#39;number&#39;</span>  <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;<?= $number; ?>&#39;</span>,
    <span style="background-color: #fff0f0">&#39;message&#39;</span> <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;<?= $message; ?>&#39;</span>,
    <span style="background-color: #fff0f0">&#39;filetype&#39;</span><span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;jpg&#39;</span>,
    <span style="background-color: #fff0f0">&#39;url&#39;</span>     <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;<?= $mediaurl; ?>&#39;</span>
];

<span style="color: #906030">$curl</span> <span style="color: #303030">=</span> <span style="color: #007020">curl_init</span>();
curl_setopt_array(<span style="color: #906030">$curl</span>, <span style="color: #008000; font-weight: bold">array</span>(
  CURLOPT_URL <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&quot;<?= $base_url;?>api/send-media.php&quot;</span>,
  CURLOPT_RETURNTRANSFER <span style="color: #303030">=&gt;</span> <span style="color: #008000; font-weight: bold">true</span>,
  CURLOPT_ENCODING <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&quot;&quot;</span>,
  CURLOPT_MAXREDIRS <span style="color: #303030">=&gt;</span> <span style="color: #0000D0; font-weight: bold">10</span>,
  CURLOPT_TIMEOUT <span style="color: #303030">=&gt;</span> <span style="color: #0000D0; font-weight: bold">0</span>,
  CURLOPT_FOLLOWLOCATION <span style="color: #303030">=&gt;</span> <span style="color: #008000; font-weight: bold">true</span>,
  CURLOPT_HTTP_VERSION <span style="color: #303030">=&gt;</span> CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&quot;POST&quot;</span>,
  CURLOPT_POSTFIELDS <span style="color: #303030">=&gt;</span> json_encode(<span style="color: #906030">$data</span>))
);

<span style="color: #906030">$response</span> <span style="color: #303030">=</span> <span style="color: #007020">curl_exec</span>(<span style="color: #906030">$curl</span>);

<span style="color: #007020">curl_close</span>(<span style="color: #906030">$curl</span>);
<span style="color: #008000; font-weight: bold">echo</span> <span style="color: #906030">$response</span>;
</pre></div>

<br><br>
<h3>PHP  CODE Webhook</h3>

<!-- HTML generated using highlightmycode --><div style="background: #ffffff; overflow:auto;width:auto;border:solid gray;border-width:.1em .1em .1em .8em;padding:.2em .6em;"><pre style="margin: 0; line-height: 125%"><span style="color: #507090">&lt;?php</span>

<span style="color: #007020">header</span>(<span style="background-color: #fff0f0">&#39;content-type: application/json&#39;</span>);
<span style="color: #906030">$data</span> <span style="color: #303030">=</span> json_decode(<span style="color: #007020">file_get_contents</span>(<span style="background-color: #fff0f0">&#39;php://input&#39;</span>), <span style="color: #008000; font-weight: bold">true</span>);
<span style="color: #007020">file_put_contents</span>(<span style="background-color: #fff0f0">&#39;whatsapp.txt&#39;</span>, <span style="background-color: #fff0f0">&#39;[&#39;</span> <span style="color: #303030">.</span> <span style="color: #007020">date</span>(<span style="background-color: #fff0f0">&#39;Y-m-d H:i:s&#39;</span>) <span style="color: #303030">.</span> <span style="background-color: #fff0f0">&quot;]</span><span style="color: #606060; font-weight: bold; background-color: #fff0f0">\n</span><span style="background-color: #fff0f0">&quot;</span> <span style="color: #303030">.</span> json_encode(<span style="color: #906030">$data</span>) <span style="color: #303030">.</span> <span style="background-color: #fff0f0">&quot;</span><span style="color: #606060; font-weight: bold; background-color: #fff0f0">\n\n</span><span style="background-color: #fff0f0">&quot;</span>, FILE_APPEND);
<span style="color: #906030">$message</span> <span style="color: #303030">=</span> <span style="color: #906030">$data</span>[<span style="background-color: #fff0f0">&#39;message&#39;</span>]; <span style="color: #808080">// catch incoming message</span>
<span style="color: #906030">$from</span> <span style="color: #303030">=</span> <span style="color: #906030">$data</span>[<span style="background-color: #fff0f0">&#39;from&#39;</span>]; <span style="color: #808080">// catch incoming sender</span>


<span style="color: #008000; font-weight: bold">if</span> (<span style="color: #007020">strtolower</span>(<span style="color: #906030">$message</span>) <span style="color: #303030">==</span> <span style="background-color: #fff0f0">&#39;hi&#39;</span>) {
    <span style="color: #906030">$result</span> <span style="color: #303030">=</span> [
        <span style="background-color: #fff0f0">&#39;mode&#39;</span> <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;chat&#39;</span>, <span style="color: #808080">// mode chat = text message chat</span>
        <span style="background-color: #fff0f0">&#39;pesan&#39;</span> <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;Hey you..&#39;</span>
    ];
} <span style="color: #008000; font-weight: bold">else</span> <span style="color: #008000; font-weight: bold">if</span> (<span style="color: #007020">strtolower</span>(<span style="color: #906030">$message</span>) <span style="color: #303030">==</span> <span style="background-color: #fff0f0">&#39;hello&#39;</span>) {
    <span style="color: #906030">$result</span> <span style="color: #303030">=</span> [
        <span style="background-color: #fff0f0">&#39;mode&#39;</span> <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;reply&#39;</span>, <span style="color: #808080">// mode reply = message reply</span>
        <span style="background-color: #fff0f0">&#39;pesan&#39;</span> <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;Oh hi.. didn't see you there.&#39;</span>
    ];
} <span style="color: #008000; font-weight: bold">else</span> <span style="color: #008000; font-weight: bold">if</span> (<span style="color: #007020">strtolower</span>(<span style="color: #906030">$message</span>) <span style="color: #303030">==</span> <span style="background-color: #fff0f0">&#39;picture&#39;</span>) {
    <span style="color: #906030">$result</span> <span style="color: #303030">=</span> [
        <span style="background-color: #fff0f0">&#39;mode&#39;</span> <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;picture&#39;</span>, <span style="color: #808080">// type picture = picture message</span>
        <span style="background-color: #fff0f0">&#39;data&#39;</span> <span style="color: #303030">=&gt;</span> [
            <span style="background-color: #fff0f0">&#39;caption&#39;</span> <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;*webhook picture*&#39;</span>,
            <span style="background-color: #fff0f0">&#39;url&#39;</span> <span style="color: #303030">=&gt;</span> <span style="background-color: #fff0f0">&#39;<?= $mediaurl; ?>&#39;</span>
        ]
    ];
}

<span style="color: #008000; font-weight: bold">print</span> json_encode(<span style="color: #906030">$result</span>);
</pre></div>


</div>
<br><br>

<h3>Respon</h3>
<div>
    ApiKey (Token) not Valid <br>
    {"status":false,"message":"Invalid ApiKey (Token)"}
    <br><br>
    
    Phone Number not Valid <br>
    {"status":false,"message":"Please scan QR code first!"}
    <br><br>
    
    Message Empty <br>
    {"status":false,"message":"Invalid Parameter"}
    <br><br>
    
    Request failed <br>
    {"status":false,"message":"Error"}
    <br><br>
    
    Url Not Valid <br>
    {"status":false,"message":"Url not Valid"}
    <br><br>
    
    Not an Image File <br>
    {"status":false,"message":"Extension not recogized"}
    <br><br>
    
    Request Success <br>
    {"status":true,"message":"Message Sent Success!"}
    <br><br>
    
   
   
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php require_once('../templates/footer.php'); ?>

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo _LOGOUT_TITLE ?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"><?php echo _LOGOUT_BODY ?></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><?php echo _CANCEL ?></button>
                <a class="btn btn-primary" href="<?= $base_url;?>auth/logout.php"><?php echo _LOGOUT ?></a>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= $base_url; ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= $base_url; ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= $base_url; ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= $base_url; ?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= $base_url; ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= $base_url; ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= $base_url; ?>js/demo/datatables-demo.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous"></script>
<script>
    <?php

    toastr_show();

    ?>
</script>
</body>

</html>
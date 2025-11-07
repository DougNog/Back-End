<?php
require_once __DIR__ . '/../controller/BebidaController.php';
$controller = new BebidaController();

$bebidaEdit = null;

// Ações CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['acao'] === 'criar') {
        $controller->criar($_POST['nome'], $_POST['categoria'], $_POST['volume'], $_POST['valor'], $_POST['qtde']);
    } elseif ($_POST['acao'] === 'deletar') {
        $controller->deletar($_POST['nome']);
    } elseif ($_POST['acao'] === 'editar') {
        $controller->atualizar($_POST['nome'], $_POST['valor'], $_POST['qtde']);
    }
}

// Carrega bebida para edição
if (isset($_GET['edit'])) {
    $listaTemp = $controller->ler();
    $nomeEdit = $_GET['edit'];
    if (isset($listaTemp[$nomeEdit])) $bebidaEdit = $listaTemp[$nomeEdit];
}

$lista = $controller->ler();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Bebidas</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- 🔮 Fundo de energia -->
    <canvas id="background"></canvas>

    <div class="container">
        <h1>Cadastro de Bebidas</h1>

        <form method="POST">
            <input type="hidden" name="acao" value="<?= $bebidaEdit ? 'editar' : 'criar' ?>">

            <input type="text" name="nome" placeholder="Nome da bebida" required
                value="<?= $bebidaEdit ? htmlspecialchars($bebidaEdit->getNome()) : '' ?>"
                <?= $bebidaEdit ? 'readonly' : '' ?>>

            <select name="categoria" <?= $bebidaEdit ? 'disabled' : '' ?> required>
                <option value="">Selecione a categoria</option>
                <?php
                $categorias = ["Refrigerante", "Cerveja", "Vinho", "Destilado", "Água", "Suco", "Energético"];
                foreach ($categorias as $cat) {
                    $selected = ($bebidaEdit && $bebidaEdit->getCategoria() === $cat) ? 'selected' : '';
                    echo "<option value='$cat' $selected>$cat</option>";
                }
                ?>
            </select>

            <input type="text" name="volume" placeholder="Volume (ex: 300ml)" required
                value="<?= $bebidaEdit ? htmlspecialchars($bebidaEdit->getVolume()) : '' ?>"
                <?= $bebidaEdit ? 'readonly' : '' ?>>

            <input type="number" name="valor" step="0.01" placeholder="Valor R$"
                value="<?= $bebidaEdit ? htmlspecialchars($bebidaEdit->getValor()) : '' ?>" required>

            <input type="number" name="qtde" placeholder="Quantidade"
                value="<?= $bebidaEdit ? htmlspecialchars($bebidaEdit->getQtde()) : '' ?>" required>

            <button type="submit"><?= $bebidaEdit ? 'Salvar Alterações' : 'Cadastrar' ?></button>

            <?php if ($bebidaEdit): ?>
                <a href="index.php" style="margin-left:10px; text-decoration:none; color:#00f5ff;">Cancelar Edição</a>
            <?php endif; ?>
        </form>

        <h2>Bebidas Cadastradas</h2>

        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Categoria</th>
                    <th>Volume</th>
                    <th>Valor (R$)</th>
                    <th>Quantidade</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($lista) > 0): ?>
                    <?php foreach ($lista as $bebida): ?>
                        <tr>
                            <td><?= htmlspecialchars($bebida->getNome()) ?></td>
                            <td><?= htmlspecialchars($bebida->getCategoria()) ?></td>
                            <td><?= htmlspecialchars($bebida->getVolume()) ?></td>
                            <td><?= htmlspecialchars(number_format($bebida->getValor(), 2, ',', '.')) ?></td>
                            <td><?= htmlspecialchars($bebida->getQtde()) ?></td>
                            <td class="actions">
                                <form method="GET" style="display:inline;">
                                    <input type="hidden" name="edit" value="<?= htmlspecialchars($bebida->getNome()) ?>">
                                    <button type="submit">Editar</button>
                                </form>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="acao" value="deletar">
                                    <input type="hidden" name="nome" value="<?= htmlspecialchars($bebida->getNome()) ?>">
                                    <button type="submit" onclick="return confirm('Deseja excluir esta bebida?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="no-data">Nenhuma bebida cadastrada ainda</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

<!-- 🌈 Fundo interativo -->
<script>
const canvas = document.getElementById('background');
const ctx = canvas.getContext('2d');
let particles=[], hue=0;
let mouse={x:null,y:null,radius:120};
let bursts=[];

canvas.width=innerWidth;
canvas.height=innerHeight;
addEventListener('resize',()=>{canvas.width=innerWidth;canvas.height=innerHeight;particles=[];init();});
addEventListener('mousemove',e=>{mouse.x=e.x;mouse.y=e.y;});
addEventListener('click',e=>{bursts.push({x:e.x,y:e.y,r:0,a:1,c:`hsl(${hue},100%,65%)`});});

class Particle{
 constructor(x,y,s,c,vx,vy){this.x=x;this.y=y;this.s=s;this.c=c;this.vx=vx;this.vy=vy;}
 update(){
  this.x+=this.vx;this.y+=this.vy;
  if(this.x<0||this.x>canvas.width)this.vx*=-1;
  if(this.y<0||this.y>canvas.height)this.vy*=-1;
  const dx=mouse.x-this.x,dy=mouse.y-this.y,d=Math.sqrt(dx*dx+dy*dy);
  if(d<mouse.radius&&mouse.x&&mouse.y){this.x-=dx/d*1.5;this.y-=dy/d*1.5;}
 }
 draw(){
  ctx.beginPath();ctx.arc(this.x,this.y,this.s,0,Math.PI*2);
  ctx.fillStyle=this.c;ctx.shadowColor=this.c;ctx.shadowBlur=15;ctx.fill();
 }
}

function init(){
 const count=Math.floor((canvas.width*canvas.height)/18000);
 for(let i=0;i<count;i++){
  const s=Math.random()*3+1,x=Math.random()*canvas.width,y=Math.random()*canvas.height;
  const vx=(Math.random()-.5)*1.2,vy=(Math.random()-.5)*1.2;
  const c=`hsl(${Math.random()*360},100%,65%)`;
  particles.push(new Particle(x,y,s,c,vx,vy));
 }
}

function connect(){
 for(let a=0;a<particles.length;a++){
  for(let b=a;b<particles.length;b++){
   const dx=particles[a].x-particles[b].x,dy=particles[a].y-particles[b].y;
   const d=Math.sqrt(dx*dx+dy*dy);
   if(d<120){
    ctx.strokeStyle=`hsla(${hue},100%,70%,${0.08-d/1500})`;
    ctx.lineWidth=1;ctx.beginPath();
    ctx.moveTo(particles[a].x,particles[a].y);
    ctx.lineTo(particles[b].x,particles[b].y);
    ctx.stroke();
   }
  }
 }
}

function waves(t){
 const grad=ctx.createRadialGradient(canvas.width/2,canvas.height/2,80,canvas.width/2,canvas.height/2,canvas.width/1.2);
 grad.addColorStop(0,`hsla(${(hue+60)%360},100%,55%,.25)`);
 grad.addColorStop(.5,`hsla(${(hue+180)%360},100%,45%,.15)`);
 grad.addColorStop(1,'rgba(0,0,0,0)');
 ctx.fillStyle=grad;ctx.fillRect(0,0,canvas.width,canvas.height);
 for(let i=0;i<3;i++){
  const amp=80+i*40,off=t*0.002+i;
  ctx.beginPath();
  for(let x=0;x<canvas.width;x+=10){
   const y=canvas.height/2+Math.sin(x*0.005+off)*amp*Math.sin(t*0.001+i);
   ctx.lineTo(x,y);
  }
  ctx.strokeStyle=`hsla(${(hue+i*50)%360},100%,60%,.12)`;
  ctx.lineWidth=1.2;ctx.stroke();
 }
}

function burstsDraw(){
 for(let i=0;i<bursts.length;i++){
  const e=bursts[i];e.r+=5;e.a-=.02;
  ctx.beginPath();ctx.arc(e.x,e.y,e.r,0,Math.PI*2);
  ctx.strokeStyle=`hsla(${hue},100%,65%,${e.a})`;
  ctx.lineWidth=3;ctx.shadowColor=e.c;ctx.shadowBlur=20;ctx.stroke();
  if(e.a<=0)bursts.splice(i,1);
 }
}

function animate(t){
 ctx.clearRect(0,0,canvas.width,canvas.height);hue+=.4;
 const grad=ctx.createRadialGradient(mouse.x||canvas.width/2,mouse.y||canvas.height/2,50,canvas.width/2,canvas.height/2,canvas.width/1.3);
 grad.addColorStop(0,`hsla(${(hue+90)%360},100%,50%,.25)`);
 grad.addColorStop(1,`hsla(${(hue+180)%360},100%,10%,.05)`);
 ctx.fillStyle=grad;ctx.fillRect(0,0,canvas.width,canvas.height);
 waves(t);burstsDraw();
 for(let i=0;i<particles.length;i++){particles[i].update();particles[i].draw();}
 connect();requestAnimationFrame(animate);
}

init();animate(0);
</script>
</body>
</html>

// ============= UTIL LOCALSTORAGE =============
const DB = {
  load(key, fallback) {
    try { return JSON.parse(localStorage.getItem(key)) ?? fallback; }
    catch { return fallback; }
  },
  save(key, data) {
    localStorage.setItem(key, JSON.stringify(data));
  }
};

// ============= DADOS INICIAIS (seed) =============
const seed = () => {
  if (!localStorage.getItem('membros')) {
    const membros = [
      {id: 'M001', nome: 'Ana Silva', email:'ana@techfit.com', modalidade:'yoga', freq: 8},
      {id: 'M002', nome: 'Bruno Souza', email:'bruno@techfit.com', modalidade:'musculacao', freq: 15},
      {id: 'M003', nome: 'Carla Ramos', email:'carla@techfit.com', modalidade:'spinning', freq: 5},
      {id: 'M004', nome: 'Diego Rocha', email:'diego@techfit.com', modalidade:'cross', freq: 12},
    ];
    DB.save('membros', membros);
  }
  if (!localStorage.getItem('turmas')) {
    const turmas = [
      {id: 'T001', nome:'Yoga Manhã', modalidade:'yoga', capacidade: 15},
      {id: 'T002', nome:'Musculação Pro', modalidade:'musculacao', capacidade: 25},
      {id: 'T003', nome:'Spinning 18h', modalidade:'spinning', capacidade: 20},
      {id: 'T004', nome:'Cross MetCon', modalidade:'cross', capacidade: 18},
    ];
    DB.save('turmas', turmas);
  }
  if (!localStorage.getItem('reservas')) DB.save('reservas', []);
  if (!localStorage.getItem('acessos')) DB.save('acessos', []);
  if (!localStorage.getItem('mensagens')) DB.save('mensagens', []);
  if (!localStorage.getItem('tickets')) DB.save('tickets', []);
  if (!localStorage.getItem('avaliacoes')) DB.save('avaliacoes', []);
};
seed();

// Helpers
const $ = (s, el=document) => el.querySelector(s);
const $$ = (s, el=document) => Array.from(el.querySelectorAll(s));
const nowISO = () => new Date().toISOString();
const uid = (p) => p + Math.random().toString(36).slice(2,8);

// ============= NAVEGAÇÃO =============
$$('.tablink').forEach(btn => {
  btn.addEventListener('click', () => {
    $$('.tablink').forEach(b=>b.classList.remove('active'));
    btn.classList.add('active');
    const tab = btn.dataset.tab;
    $$('.tab').forEach(s => s.classList.remove('active'));
    $('#' + tab).classList.add('active');
  });
});

// ============= POPULAR SELECTS GLOBAIS =============
function refreshGlobalSelects() {
  const membros = DB.load('membros', []);
  const turmas  = DB.load('turmas', []);

  // Agendamento
  const ag_m = $('#ag_membro'); const ag_mod = $('#ag_modalidade'); const ag_t = $('#ag_turma');
  const ac_m = $('#ac_membro');
  const tk_m = $('#tk_membro');
  const av_m = $('#av_membro'); const av_sel = $('#av_sel_membro');

  [ag_m, ac_m, tk_m, av_m, av_sel].forEach(sel => {
    if (!sel) return;
    sel.innerHTML = membros.map(m => `<option value="${m.id}">${m.nome} (${m.id})</option>`).join('');
  });

  const modalidades = ['musculacao','yoga','spinning','cross'];
  ag_mod.innerHTML = modalidades.map(x=> `<option>${x}</option>`).join('');
  ag_t.innerHTML = turmas.map(t => `<option value="${t.id}">${t.nome} [${t.modalidade}] (cap ${t.capacidade})</option>`).join('');
}
refreshGlobalSelects();

// ============= TABELA BUILDER =============
function buildTable(container, headCols, rows, key='id') {
  container.innerHTML = '';
  const head = document.createElement('div');
  head.className = 'head';
  head.innerHTML = headCols.map(h=> `<div>${h}</div>`).join('');
  container.appendChild(head);

  rows.forEach(r => {
    const row = document.createElement('div');
    row.className = 'row';
    row.dataset.key = r[key];
    headCols.forEach(c => {
      const k = c.toLowerCase();
      row.innerHTML += `<div title="${r[c] ?? r[k] ?? ''}">${r[c] ?? r[k] ?? ''}</div>`;
    });
    row.addEventListener('click', ()=>{
      $$('.row', container).forEach(x=>x.classList.remove('selected'));
      row.classList.add('selected');
    });
    container.appendChild(row);
  });
}

// ============= AGENDAMENTO =============
function refreshReservas() {
  const reservas = DB.load('reservas', []);
  const membros = DB.load('membros', []);
  const turmas = DB.load('turmas', []);
  const rows = reservas.map(r => {
    const m = membros.find(x=>x.id===r.membroId);
    const t = turmas.find(x=>x.id===r.turmaId);
    return {
      ID: r.id,
      Membro: m? m.nome : r.membroId,
      Turma: t? t.nome : r.turmaId,
      Data: r.data,
      Hora: r.hora,
      Status: r.status
    };
  });
  buildTable($('#listaReservas'), ['ID','Membro','Turma','Data','Hora','Status'], rows, 'ID');
}
refreshReservas();

$('#formAgendamento').addEventListener('submit', (e)=>{
  e.preventDefault();
  const membroId = $('#ag_membro').value;
  const turmaId  = $('#ag_turma').value;
  const data     = $('#ag_data').value;
  const hora     = $('#ag_hora').value;

  if(!data || !hora) return alert('Informe data e hora');

  // capacidade e fila de espera
  const reservas = DB.load('reservas', []);
  const turma = DB.load('turmas', []).find(t=>t.id===turmaId);
  const ja = reservas.filter(r => r.turmaId===turmaId && r.data===data && r.hora===hora);
  const status = (ja.length >= (turma?.capacidade ?? 20)) ? 'lista_espera' : 'confirmado';

  const nova = {id: uid('R'), membroId, turmaId, data, hora, status, ts: nowISO()};
  reservas.push(nova);
  DB.save('reservas', reservas);
  refreshReservas();
  alert(status==='confirmado' ? 'Reserva confirmada!' : 'Turma cheia. Você entrou na lista de espera.');
});

$('#btnCancelarReserva').addEventListener('click', ()=>{
  const cont = $('#listaReservas');
  const sel = $('.row.selected', cont);
  if(!sel) return alert('Selecione uma reserva');
  const id = sel.dataset.key;
  const reservas = DB.load('reservas', []);
  const i = reservas.findIndex(r => r.id===id);
  if (i>=0) reservas.splice(i,1);
  DB.save('reservas', reservas);
  refreshReservas();
});

$('#btnRelOcupacao').addEventListener('click', ()=>{
  const reservas = DB.load('reservas', []);
  const turmas = DB.load('turmas', []);
  const mapa = {};
  reservas.forEach(r => {
    const key = `${r.turmaId}|${r.data}|${r.hora}`;
    mapa[key] = (mapa[key] || 0) + 1;
  });
  const rows = Object.entries(mapa).map(([k,v])=>{
    const [tid, data, hora] = k.split('|');
    const t = turmas.find(x=>x.id===tid);
    const cap = t?.capacidade ?? 20;
    const ocup = Math.min(v, cap);
    const lista = Math.max(0, v - cap);
    return {Turma: t? t.nome:tid, Data:data, Hora:hora, Ocupacao: `${ocup}/${cap}`, Lista_Espera: lista};
  });
  buildTable($('#ocupacao'), ['Turma','Data','Hora','Ocupacao','Lista_Espera'], rows, 'Turma');
});

// ============= CONTROLE DE ACESSO =============
function refreshAcessos(){
  const acessos = DB.load('acessos', []);
  const membros = DB.load('membros', []);
  const rows = acessos.slice().reverse().map(a=>{
    const m = membros.find(x=>x.id===a.membroId);
    return {
      ID: a.id,
      Membro: m? m.nome : a.membroId,
      Metodo: a.metodo,
      DataHora: new Date(a.ts).toLocaleString(),
      Resultado: a.resultado,
      Obs: a.obs || ''
    };
  });
  buildTable($('#listaAcessos'), ['ID','Membro','Metodo','DataHora','Resultado','Obs'], rows, 'ID');
}
refreshAcessos();

$('#formAcesso').addEventListener('submit', (e)=>{
  e.preventDefault();
  const membroId = $('#ac_membro').value;
  const metodo = $('#ac_metodo').value;
  const ok = Math.random() > .02; // 98% sucesso
  const acessos = DB.load('acessos', []);
  acessos.push({id: uid('A'), membroId, metodo, ts: nowISO(), resultado: ok? 'OK':'NEGADO', obs: ok? '': 'Falha na leitura'});
  DB.save('acessos', acessos);
  refreshAcessos();
});

$('#btnExportAcessos').addEventListener('click', ()=>{
  const acessos = DB.load('acessos', []);
  const header = ['id','membroId','metodo','ts','resultado','obs'];
  const lines = [header.join(',')].concat(acessos.map(a => header.map(h=> `"${String(a[h]??'').replaceAll('"','""')}"`).join(',')));
  const blob = new Blob([lines.join('\n')], {type:'text/csv'});
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a'); a.href = url; a.download='acessos.csv'; a.click();
  URL.revokeObjectURL(url);
});

// ============= COMUNICAÇÃO =============
function refreshMensagens(){
  const msgs = DB.load('mensagens', []);
  const rows = msgs.slice().reverse().map(m => ({
    ID: m.id, Titulo: m.titulo, Segmentos: m.segmentos.join('|'), Envio: new Date(m.ts).toLocaleString(), Destinatarios: m.destinatarios
  }));
  buildTable($('#listaMensagens'), ['ID','Titulo','Segmentos','Envio','Destinatarios'], rows, 'ID');
}
refreshMensagens();

$('#formMensagem').addEventListener('submit', (e)=>{
  e.preventDefault();
  const titulo = $('#msg_titulo').value.trim();
  const corpo  = $('#msg_corpo').value.trim();
  const segs = $$('.seg_chk:checked').map(i=>i.value);
  if (!segs.length) return alert('Selecione pelo menos um segmento.');
  const membros = DB.load('membros', []);
  const candidatos = membros.filter(m => {
    const segModal = segs.some(s => ['musculacao','yoga','spinning','cross'].includes(s) && m.modalidade === s);
    const segFreq   = segs.includes('alta-frequencia') ? (m.freq || 0) >= 12 : false;
    return segModal || segFreq;
  });
  const mensagens = DB.load('mensagens', []);
  mensagens.push({id: uid('C'), titulo, corpo, segmentos: segs, destinatarios: candidatos.length, ts: nowISO()});
  DB.save('mensagens', mensagens);
  refreshMensagens();
  alert(`Mensagem enviada para ${candidatos.length} membros.`);
  e.target.reset();
});

$('#btnNovaCampanha').addEventListener('click', ()=>{
  const cont = $('#listaMensagens');
  const sel = $('.row.selected', cont);
  if(!sel) return alert('Selecione uma campanha');
  const id = sel.dataset.key;
  const mensagens = DB.load('mensagens', []);
  const base = mensagens.find(m=>m.id===id);
  if(!base) return;
  $('#msg_titulo').value = `[RE] ${base.titulo}`;
  $('#msg_corpo').value  = base.corpo;
  $$('.seg_chk').forEach(c => c.checked = base.segmentos.includes(c.value));
  alert('Campos preenchidos a partir da campanha selecionada.');
});

$('#btnRemoverCampanha').addEventListener('click', ()=>{
  const cont = $('#listaMensagens');
  const sel = $('.row.selected', cont);
  if(!sel) return alert('Selecione uma campanha');
  const id = sel.dataset.key;
  const mensagens = DB.load('mensagens', []);
  const i = mensagens.findIndex(m=>m.id===id);
  if(i>=0){ mensagens.splice(i,1); DB.save('mensagens', mensagens); refreshMensagens(); }
});

// Tickets
function refreshTickets(){
  const tks = DB.load('tickets', []);
  const membros = DB.load('membros', []);
  const rows = tks.slice().reverse().map(t=>{
    const m = membros.find(x=>x.id===t.membroId);
    return {ID:t.id, Membro:m?m.nome:t.membroId, Assunto:t.assunto, Status:t.status, AbertoEm:new Date(t.abertoEm).toLocaleString(), UltimaResposta: new Date(t.ultResp).toLocaleString()};
  });
  buildTable($('#listaTickets'), ['ID','Membro','Assunto','Status','AbertoEm','UltimaResposta'], rows, 'ID');
}
refreshTickets();

$('#formTicket').addEventListener('submit', (e)=>{
  e.preventDefault();
  const membroId = $('#tk_membro').value;
  const assunto = $('#tk_assunto').value;
  const mensagem = $('#tk_mensagem').value;
  const tickets = DB.load('tickets', []);
  tickets.push({id: uid('TKT'), membroId, assunto, mensagens:[{de:'membro', texto:mensagem, ts: nowISO()}], status:'aberto', abertoEm: nowISO(), ultResp: nowISO()});
  DB.save('tickets', tickets);
  refreshTickets();
  e.target.reset();
});

$('#btnResponderTicket').addEventListener('click', ()=>{
  const cont = $('#listaTickets');
  const sel = $('.row.selected', cont);
  if(!sel) return alert('Selecione um ticket');
  const id = sel.dataset.key;
  const tickets = DB.load('tickets', []);
  const t = tickets.find(x=>x.id===id);
  const resp = prompt('Responder ao membro:');
  if(resp){
    t.mensagens.push({de:'suporte', texto: resp, ts: nowISO()});
    t.ultResp = nowISO();
    DB.save('tickets', tickets);
    refreshTickets();
  }
});

$('#btnFecharTicket').addEventListener('click', ()=>{
  const cont = $('#listaTickets');
  const sel = $('.row.selected', cont);
  if(!sel) return alert('Selecione um ticket');
  const id = sel.dataset.key;
  const tickets = DB.load('tickets', []);
  const t = tickets.find(x=>x.id===id);
  t.status = 'fechado';
  t.ultResp = nowISO();
  DB.save('tickets', tickets);
  refreshTickets();
});

// ============= AVALIAÇÃO FÍSICA =============
function refreshAvaliacoesList(membroId) {
  const avs = DB.load('avaliacoes', []).filter(a=>a.membroId===membroId).sort((a,b)=> a.ts.localeCompare(b.ts));
  const rows = avs.map(a => ({
    Data: new Date(a.ts).toLocaleDateString(),
    Peso: a.peso.toFixed(1),
    Altura: a.altura + ' cm',
    Gordura: a.gordura.toFixed(1) + '%',
    Cintura: a.cintura.toFixed(1) + ' cm',
    IMC: (a.peso / Math.pow(a.altura/100,2)).toFixed(1)
  }));
  buildTable($('#listaAvaliacoes'), ['Data','Peso','Altura','Gordura','Cintura','IMC'], rows, 'Data');
}

$('#formAvaliacao').addEventListener('submit', (e)=>{
  e.preventDefault();
  const membroId = $('#av_membro').value;
  const peso = parseFloat($('#av_peso').value);
  const altura = parseInt($('#av_altura').value, 10);
  const gordura = parseFloat($('#av_gordura').value);
  const cintura = parseFloat($('#av_cintura').value);
  const obs = $('#av_obs').value.trim();
  const avs = DB.load('avaliacoes', []);
  avs.push({id: uid('AV'), membroId, peso, altura, gordura, cintura, obs, ts: nowISO()});
  DB.save('avaliacoes', avs);
  refreshAvaliacoesList(membroId);
  alert('Avaliação registrada. Próxima avaliação sugerida em 60 dias.');
  e.target.reset();
});

$('#btnGerarGrafico').addEventListener('click', ()=>{
  const membroId = $('#av_sel_membro').value;
  const avs = DB.load('avaliacoes', []).filter(a=>a.membroId===membroId).sort((a,b)=> a.ts.localeCompare(b.ts));
  const svg = $('#grafico');
  svg.innerHTML = ''; // reset
  if (avs.length < 2) {
    svg.innerHTML = `<text x="10" y="30">Adicione pelo menos 2 avaliações para visualizar o gráfico.</text>`;
    return;
  }
  // Construir gráfico simples de evolução do peso
  const W=600, H=200, pad=30;
  const xs = avs.map((_,i)=> i);
  const ys = avs.map(a=> a.peso);
  const xmin=0, xmax=xs.length-1;
  const ymin=Math.min(...ys)-1, ymax=Math.max(...ys)+1;
  const sx = x => pad + (W-2*pad)*( (x-xmin) / (xmax-xmin||1) );
  const sy = y => H-pad - (H-2*pad)*( (y-ymin) / (ymax-ymin||1) );
  // eixos
  svg.innerHTML += `<line x1="${pad}" y1="${H-pad}" x2="${W-pad}" y2="${H-pad}" stroke="#94a3b8" />`;
  svg.innerHTML += `<line x1="${pad}" y1="${pad}" x2="${pad}" y2="${H-pad}" stroke="#94a3b8" />`;
  // linha
  let d = '';
  ys.forEach((y,i)=>{
    const X = sx(i), Y = sy(y);
    d += (i? ' L':'M') + X + ' ' + Y;
    // pontos
    svg.innerHTML += `<circle cx="${X}" cy="${Y}" r="3"></circle>`;
  });
  svg.innerHTML += `<path d="${d}" fill="none" stroke="#2563eb" stroke-width="2"></path>`;
});

$('#av_sel_membro').addEventListener('change', (e)=>{
  refreshAvaliacoesList(e.target.value);
});

// ============= PAINEL ADMINISTRATIVO =============
function refreshMembros(){
  const membros = DB.load('membros', []);
  const rows = membros.map(m=> ({ID:m.id, Nome:m.nome, Email:m.email, Modalidade:m.modalidade, Freq_Mensal: m.freq || 0}));
  buildTable($('#listaMembros'), ['ID','Nome','Email','Modalidade','Freq_Mensal'], rows, 'ID');
}
refreshMembros();

$('#formMembro').addEventListener('submit', (e)=>{
  e.preventDefault();
  const nome = $('#mb_nome').value.trim();
  const email = $('#mb_email').value.trim();
  const modalidade = $('#mb_modalidade').value;
  const membros = DB.load('membros', []);
  const novo = {id: uid('M'), nome, email, modalidade, freq: 0};
  membros.push(novo);
  DB.save('membros', membros);
  refreshMembros();
  refreshGlobalSelects();
  e.target.reset();
});

$('#btnRemoverMembro').addEventListener('click', ()=>{
  const cont = $('#listaMembros');
  const sel = $('.row.selected', cont);
  if(!sel) return alert('Selecione um membro');
  const id = sel.dataset.key;
  const membros = DB.load('membros', []);
  const i = membros.findIndex(x=>x.id===id);
  if(i>=0) { membros.splice(i,1); DB.save('membros', membros); refreshMembros(); refreshGlobalSelects(); }
});

function refreshTurmas(){
  const turmas = DB.load('turmas', []);
  const rows = turmas.map(t=> ({ID:t.id, Nome:t.nome, Modalidade:t.modalidade, Capacidade:t.capacidade}));
  buildTable($('#listaTurmas'), ['ID','Nome','Modalidade','Capacidade'], rows, 'ID');
}
refreshTurmas();

$('#formTurma').addEventListener('submit', (e)=>{
  e.preventDefault();
  const nome = $('#tm_nome').value.trim();
  const modalidade = $('#tm_modalidade').value;
  const capacidade = parseInt($('#tm_capacidade').value, 10) || 20;
  const turmas = DB.load('turmas', []);
  turmas.push({id: uid('T'), nome, modalidade, capacidade});
  DB.save('turmas', turmas);
  refreshTurmas();
  refreshGlobalSelects();
  e.target.reset();
});

$('#btnRemoverTurma').addEventListener('click', ()=>{
  const cont = $('#listaTurmas');
  const sel = $('.row.selected', cont);
  if(!sel) return alert('Selecione uma turma');
  const id = sel.dataset.key;
  const turmas = DB.load('turmas', []);
  const i = turmas.findIndex(x=>x.id===id);
  if(i>=0) { turmas.splice(i,1); DB.save('turmas', turmas); refreshTurmas(); refreshGlobalSelects(); }
});

// Relatórios
$('#btnRelatorioFrequencia').addEventListener('click', ()=>{
  const acessos = DB.load('acessos', []);
  const membros = DB.load('membros', []);
  const contagem = {};
  acessos.forEach(a=>{
    const dia = new Date(a.ts).toISOString().slice(0,10);
    contagem[dia] = (contagem[dia]||0) + 1;
  });
  const rows = Object.entries(contagem).sort((a,b)=> a[0].localeCompare(b[0]))
    .map(([dia,q])=> ({Dia: dia, Entradas: q}));
  buildTable($('#areaRelatorios'), ['Dia','Entradas'], rows, 'Dia');
});

$('#btnRelatorioFinanceiro').addEventListener('click', ()=>{
  const membros = DB.load('membros', []);
  const planos = {musculacao:139.9, yoga:119.9, spinning:129.9, cross:159.9};
  const receita = membros.reduce((acc,m)=> acc + (planos[m.modalidade] || 129.9), 0);
  const inadimpl = Math.round(membros.length * 0.07); // simulado 7%
  const rows = [
    {Indicador:'Membros Ativos', Valor: membros.length},
    {Indicador:'Receita Mensal Estimada (R$)', Valor: receita.toFixed(2)},
    {Indicador:'Inadimplência Estimada', Valor: inadimpl}
  ];
  buildTable($('#areaRelatorios'), ['Indicador','Valor'], rows, 'Indicador');
});

// Inicializar histórico padrão para um membro (para o gráfico demo)
(function seedAvaliacoesDemo(){
  const avs = DB.load('avaliacoes', []);
  const membros = DB.load('membros', []);
  if (avs.length===0 && membros[0]) {
    const m = membros[0].id;
    const basePeso = 72;
    for (let i=5; i>=0; i--) {
      const d = new Date(); d.setMonth(d.getMonth()-i);
      avs.push({id: uid('AV'), membroId:m, peso: basePeso + (Math.random()*4-2), altura: 168, gordura: 22 + (Math.random()*2-1), cintura: 80 + (Math.random()*2-1), obs:'', ts: d.toISOString()});
    }
    DB.save('avaliacoes', avs);
  }
})();

// Ajustes iniciais de UI
refreshGlobalSelects();
refreshAvaliacoesList($('#av_sel_membro').value || (DB.load('membros', [])[0]?.id ?? ''));

const baseUrl = document.querySelector('#base-url').value+"/routes/pix.php";
	
const tipoDevedor = document.querySelector('#tipo-devedor');
const formCriaPix = document.querySelector('#form-cria-pix');
const btnCriaPix = document.querySelector('#btn-cria-pix');
let txidCriado = '';
let btnCriaPixFlag = true;

//preencheCampos();

tipoDevedor.addEventListener('change', () => {
	const title = document.querySelector('#cpf-cnpj-title');
    const cpfCnpj = document.querySelector('#cpf-cnpj');
	cpfCnpj.value = '';
	if(tipoDevedor.value == 'cpf'){
		title.innerText = "CPF";
        cpfCnpj.placeholder = 'CPF';
		cpfCnpj.maxLength = '11';
	}else{
		title.innerText = "CNPJ";
        cpfCnpj.placeholder = 'CNPJ';
		cpfCnpj.maxLength = '14';
	}
});
			
formCriaPix.addEventListener('submit', (e) =>{
    e.preventDefault();
    criaPix();
});

function openModalSpinner(){
	const modalFundo = document.querySelector('#modalfundo');
    const spinner = document.querySelector('.spinner');
    modalFundo.style.display = 'block';
    spinner.classList.add('active-spinner');
}

function closeModalSpinner(){
	const modalFundo = document.querySelector('#modalfundo');
    const spinner = document.querySelector('.spinner');
    modalFundo.style.display = 'none';
    spinner.classList.remove('active-spinner');
}

function preencheCampos(){
    document.querySelector('#recebedor').value = '1';
	document.querySelector('#tipo-devedor').value = 'cpf';
	document.querySelector('#cpf-cnpj').value = '14279025002';
	document.querySelector('#nome-devedor').value = 'renato';
	document.querySelector('#valor').value = '0.50';
	document.querySelector('#solicitacao-pagador').value = 'teste produto';
}
			
function criaPix(){
	if(btnCriaPixFlag){
		openModalSpinner();
		btnCriaPixFlag = false;
		btnCriaPix.value = 'Criando...';
		const recebedor = document.querySelector('#recebedor').value;
		const tipoDevedor = document.querySelector('#tipo-devedor').value;
		const cpfCnpj = document.querySelector('#cpf-cnpj').value;
		const nomeDevedor = document.querySelector('#nome-devedor').value;
		const valor = document.querySelector('#valor').value;
		const solicitacaoPagador = document.querySelector('#solicitacao-pagador').value;
		
		const form = new FormData();
		form.append('recebedor', recebedor);
		form.append('tipoDevedor', tipoDevedor);
		form.append('cpfCnpj', cpfCnpj);
		form.append('nomeDevedor', nomeDevedor);
		form.append('valor', valor);
		form.append('solicitacao', solicitacaoPagador);
					
		fetch(baseUrl+'?op=cria-pix', {
			method: 'POST',
			body: form
		}).then((response) => {
			return response.json();
		}).then((response) => {
			closeModalSpinner();
			console.log(response);
			if(response.success){
				const qrcode = document.querySelector('#qrcode');
				const pix = response.dados.response.dados;
				const result = document.querySelector('#modal-body');
				let html = "<img id='img-qrcode' src='data:image/png;base64, "+pix.qrcodeImage+"' />";
				html += "<div class='pix-qrcode'><strong>Código copia e cola: </strong><p>"+pix.qrcode+"</p></div>";
				html += "<div id='consulta-pix-div'>";
				html +=  "<div id='consulta-pix'>";
				html += "<button id='btn-consulta-pix' onclick='consultaPix()'>Consultar Pix</button>";
				html += "</div>";
				html += "</div>";
				result.innerHTML = html;
				txidCriado = pix.txid;
				abrirModal();
			}else{
				alert(response.msg);
				imprimeErros(response);
			}			
			btnCriaPix.value = 'Gerar Pix';
			btnCriaPixFlag = true;
		}).catch((error) => {
			closeModalSpinner();
			console.log(error);
			alert('Erro ao gerar pix!');
			btnCriaPix.value = 'Gerar Pix';
			btnCriaPixFlag = true;
		});
	}
				
}

function consultaPix(){
	if(txidCriado != ''){
		fecharModal();
		openModalSpinner();
		fetch(baseUrl+'?op=find-pix&txid='+txidCriado)
		.then((response) => {
			return response.json();
		}).then((response) => {
			console.log(response);
			closeModalSpinner();
			abrirModal();
			if(response.success){
				const pix = response.dados.response.dados;
				alert("Pix status "+pix.status);
			}else{
				alert(response.msg);
			}
		});
	}
	
	
}

function abrirModal(){
	const modalPix = $('#modal-pix');
	modalPix.modal('show');
}

//fecha o modal para adicionar o prato ao pedido
function fecharModal(){
	const modalPix = $('#modal-pix');
	modalPix.modal('hide');
}


			
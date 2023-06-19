var video = document.querySelector('video');
navigator.mediaDevices.getUserMedia({ video: true })
  .then(stream => {
    video.srcObject = stream;
    video.play();
    video.style.height = '174px';
    video.style.width = '200px';
  })
  .catch(error => {
    console.log(error);
  });
document.querySelector('button').addEventListener('click', () => {
  var canvas = document.querySelector('canvas');
  canvas.height = video.videoHeight;
  canvas.width = video.videoWidth;
  var context = canvas.getContext('2d');
  context.drawImage(video, 0, 0);
  var link = document.createElement('a');
  canvas.style.height = '174px';
  canvas.style.width = '200px';
  link.download = 'foto.png';
  link.href = canvas.toDataURL();
  link.textContent = '--->   CLIQUE PARA BAIXAR A IMAGEM   <---';
  // Estilize o link de download da imagem
  link.style.background = 'green';
  link.style.color = 'white';
  link.style.textDecoration = 'none';
  link.style.fontWeight = 'bolder';
  link.style.position = 'fixed';
  link.style.top = '0';
  link.style.left = '0';
  link.style.right = '0';
  document.body.appendChild(link);
  // Direcione a imagem capturada para o campo de entrada de arquivo
  var inputFile = document.querySelector('input[name="arquivo"]');
  if (inputFile) {
    var selectedFile = dataURLtoFile(link.href, 'foto.png');
    var fileData = new DataTransfer();
    fileData.items.add(selectedFile);
    inputFile.files = fileData.files;
  }
});
// Função para converter a imagem capturada em um arquivo
function dataURLtoFile(dataURL, filename) {
  var arr = dataURL.split(',');
  var mime = arr[0].match(/:(.*?);/)[1];
  var bstr = atob(arr[1]);
  var n = bstr.length;
  var u8arr = new Uint8Array(n);
  while (n--) {
    u8arr[n] = bstr.charCodeAt(n);
  }
  return new File([u8arr], filename, { type: mime });
}


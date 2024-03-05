<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>

<body>
  <div>
    <div id="logged"></div>
  </div>
  <div>
    <form id="form">
      <input type="text" name="email" value="diego@gmail.com" id="">
      <input type="text" name="password" value="12345" id="">
      <button type="submit" class="btn-login" id="">Login</button>
    </form>
  </div>
  <div>
    <button id="btn_check_auth" class="btn-auth">Verificar autenticação</button>
  </div>

  <script>
    const form = document.querySelector('#form');

    axios.default.baseURL = 'http://localhost';

    form.addEventListener('submit', async function(event) {
      event.preventDefault();

      try {
        const formData = new FormData(event.target);

        const { data } = await axios.post('login.php', formData);

        sessionStorage.setItem('session', data);
      } catch (error) {
        console.log(error);
      }
    });
  </script>
</body>

</html>
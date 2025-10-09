document.getElementById("loginForm").addEventListener("submit", function(e) {
  e.preventDefault();

  const username = document.getElementById("username").value.trim();
  const password = document.getElementById("password").value.trim();
  const errorMsg = document.getElementById("error");

  // Usuários fictícios para teste
  const users = [
    { user: "admin", pass: "1234", role: "admin" },
    { user: "usuario", pass: "1234", role: "user" }
  ];

  const valid = users.find(u => u.user === username && u.pass === password);

  if (valid) {
    // Salva papel no localStorage
    localStorage.setItem("role", valid.role);
    // Redireciona para a página principal
    window.location.href = "index.html";
  } else {
    errorMsg.textContent = "Usuário ou senha inválidos!";
  }
});
const toggle = document.getElementById('toggle-login');
const loginActive = document.getElementById('login-active');
const title = document.getElementById('login-modal-label');
const actionButton = document.getElementById('action-button');
const email = document.getElementById('email');
const password = document.getElementById('password');

toggle.addEventListener('click', e => {
  e.preventDefault();

  if (loginActive.value === '1') {
    console.log('login -> signup');
    loginActive.value = '0';

    title.textContent = 'Sign up';
    actionButton.textContent = 'Sign up';
    toggle.textContent = 'Log in';
  } else {
    console.log('signup -> login');
    loginActive.value = '1';

    title.textContent = 'Log in';
    actionButton.textContent = 'Log in';
    toggle.textContent = 'Sign up';
  }
});

actionButton.addEventListener('click', async () => {
  const response = await fetch('/actions.php?action=login', {
    method: 'post',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      email: email.value,
      password: password.value,
      loginActive: loginActive.value
    })
  });

  console.log(await response.json());
  console.log(await response.text());
});

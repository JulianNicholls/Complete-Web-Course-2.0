const loginActive = document.getElementById('login-active');
const title = document.getElementById('login-modal-label');
const actionButton = document.getElementById('action-button');
const toggleLogin = document.getElementById('toggle-login');
const toggleFollows = document.querySelectorAll('.toggle-follow');

// Switch between login and signup
toggleLogin.addEventListener('click', e => {
  e.preventDefault();

  if (loginActive.value === '1') {
    console.log('login -> signup');
    loginActive.value = '0';

    title.innerText = 'Sign up';
    actionButton.innerText = 'Sign up';
    toggleLogin.innerText = 'Log in';
  } else {
    console.log('signup -> login');
    loginActive.value = '1';

    title.innerText = 'Log in';
    actionButton.innerText = 'Log in';
    toggleLogin.innerText = 'Sign up';
  }
});

// Sign up or log in
actionButton.addEventListener('click', async () => {
  const email = document.getElementById('email').value;
  const password = document.getElementById('password').value;

  const response = await fetch('/actions.php?action=login', {
    method: 'post',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      email,
      password,
      loginActive: loginActive.value
    })
  });

  const data = await response.json();

  console.log(data);

  if (data.errors.length === 0) {
    window.location.assign('/');
  } else {
    const loginErrors = document.getElementById('login-errors');
    const content = data.errors.join('<br>');

    loginErrors.innerHTML = content;
    loginErrors.classList.add('alert', 'alert-danger');
  }
});

[...toggleFollows].forEach(tf => tf.addEventListener('click', toggleFollow));

async function toggleFollow(e) {
  const { userId } = e.target.dataset;

  const response = await fetch('/actions.php?action=toggleFollow', {
    method: 'post',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ userId })
  });

  const data = await response.json();
  const linksForUser = document.querySelectorAll(
    `button[data-user-id="${userId}"]`
  );

  console.log({ data, linksForUser });

  [...linksForUser].forEach(
    link => (link.innerText = data.following ? 'Unfollow' : 'Follow')
  );
}

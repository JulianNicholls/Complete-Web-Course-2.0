    <!-- jQuery first, then Tether, then Bootstrap JS. -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js"
            integrity="sha384-THPy051/pYDQGanwU6poAc/hOdQxjnOEXzbT+OuUAFqNqFjL+4IGLBgCJC3ZOShY" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.2.0/js/tether.min.js"
            integrity="sha384-Plbmg8JY28KFelvJVai01l8WyZzrYWG825m+cZ0eDDS1f7d/js6ikvy1+X+guPIB" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.5/js/bootstrap.min.js" crossorigin="anonymous"></script>

    <script>
$(".flip-forms").on('click', evt => {
const $signup_form = $("#signup-form");
const $login_form  = $("#login-form");

if($signup_form.is(':visible')) {
  $signup_form.fadeOut(() => $login_form.fadeIn());
}
else {
  $login_form.fadeOut(() => $signup_form.fadeIn());
}

return false;
});

let diary_content = '';

$("#diary-text").bind('input propertychange selectionchange', () => {
  const new_text = $("#diary-text").val();

  if (new_text !== diary_content) {
//    console.log(`Changed: ${new_text}`);

    $.ajax({
      method: 'post',
      url: 'update-diary.php',
      data: { diary: new_text }
    });

    diary_content = new_text;
  }

  return false;
});
    </script>
  </body>
</html>


document.addEventListener('DOMContentLoaded', function () {
	$('#button_send').on('click', function(event) {
		$('.name_error').hide();
		$('.email_error').hide();
		$('.phone_error').hide();

		$('#name').css({'border':''});
		$('#email').css({'border':''});
		$('#phone').css({'border':''});

		let name = $('#name').val().trim();
		let email = $('#email').val().trim();
		let phone = $('#phone').val().trim();

		if (email.indexOf('@') === -1 || email.indexOf('.') === -1) {
			console.log('email должен содержать символы @ и .');
			$('.email_error td').text('email должен содержать символы @ и .');
			$('#email').css({'border':'2px solid red'});
			$('.email_error').show();
			return;
		}

		if (name !== '' && email !== '' && phone !== '') {
			email = email.toLowerCase();
			phone = phone.replace(/[^0-9]/gi, '');
			console.log(name);
			console.log(email);
			console.log(phone);
			send(name, email, phone)
		} else if (name === '') {
			$('.name_error td').text('Введите имя');
			$('#name').css({'border':'2px solid red'});
			$('.name_error').show();
			console.log('Введите имя');
		} else if (email === '') {
			$('.email_error td').text('Введите email');
			$('#email').css({'border':'2px solid red'});
			$('.email_error').show();
			console.log('Введите email');
		} else if (phone === '') {
			$('.phone_error td').text('Введите телефон');
			$('#phone').css({'border':'2px solid red'});
			$('.phone_error').show();
			console.log('Введите phone');
		}
	});

	$('#email').on('input', function(event) {
		this.value = this.value.replace(/[^a-zA-Z0-9@._-]/gi, '');
	});

	$('#phone').mask('+7(999) 999-9999');

	$('.name_error').hide();
	$('.email_error').hide();
	$('.phone_error').hide();

});

function send(name, email, phone) {
	let url = '/send.php';
	let data = {
		'name': name,
		'email': email,
		'phone': phone
	}

	$.post(url, data)
		.fail(function (err) {
			console.log(err);
			$('.form').html('<div><p>Произошла следующая ошибка</p><p>' + err + '</p><p>Ваша заявка успешно отправлена, менеджер в скором времени свяжется с вами по указанным вами контактам</p><p><a href="/">Перейти к созданию новой заявки</a></p></div>');
		})
		.then(function (response) {
			console.log(response);
			$('.form').html('<div><p>Ваша заявка успешно отправлена, менеджер в скором времени свяжется с вами по указанным вами контактам</p><p><a href="/">Перейти к созданию новой заявки</a></p></div>');
		});
}
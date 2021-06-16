<html>
<head>
<style>
	.form {
		width: max-content;
		margin: 50 auto;
		text-align: center;
	}

	.info_td {
		width: 75px;
	}

	.td_send {
		text-align: center;
	}

	td {
		padding-top: 5px;
		padding-bottom: 5px;
	}

	.name_error td, .email_error td, .phone_error td {
		color: red;
		text-align: right;
		padding-top: 3px !important;
		padding-bottom: 8px !important;
	}
</style>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.2.1/dist/jquery.min.js" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js" type="text/javascript"></script>
<script src="/js/script.js"></script>
</head>
<body>
	<div class="form">
		<h3>Тестовая форма Amocrm</h3>
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td class="info_td">
                    <span>Имя:</span>
                </td>
				<td>
                    <input id="name" size="30" type="text">
                </td>
			</tr>
			<tr class="name_error">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="info_td">
                    <span>Email:</span>
                </td>
				<td>
                    <input id="email" size="30" type="text">
                </td>
			</tr>
			<tr class="email_error">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="info_td">
                    <span>Телефон:</span>
                </td>
				<td>
                    <input id="phone" size="30" type="text">
                </td>
			</tr>
			<tr class="phone_error">
				<td colspan="2"></td>
			</tr>
			<tr>
				<td class="td_send" colspan="2"><button id="button_send">Отправить заявку</button></td>
			</tr>
		</table>
	</div>
</body>
</html>
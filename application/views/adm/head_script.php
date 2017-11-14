<script type="text/javascript">
	function form_post(type, table, id, service){
		var form = document.getElementById('m_frm');

		form.method = "POST";
		form.id.value = id;
		if(type == "mod"){
			if(table == "serv"){
				form.action = "/cdol/adm/services/mod_form";
			} else if (table == "menu"){
				form.action = "/cdol/adm/menus/mod_form";
			} else if (table == "user"){
				form.action = "/cdol/adm/users/mod_form";
			}
		} else if (type == "del") {
			if(confirm("real?")){
				if(table == "serv"){
					form.action = "/cdol/adm/services/del_service";
				} else if (table == "menu"){
					var serv = document.createElement("input");
					serv.setAttribute("type", "hidden");
					serv.setAttribute("name", "service");
					serv.setAttribute("value", service);
					form.appendChild(serv);

					form.action = "/cdol/adm/menus/del_menu";
				} else if (table == "user"){
					form.action = "/cdol/adm/users/del_user";
				}
			}
		}
	}
</script>

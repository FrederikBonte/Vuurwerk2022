function on_add_basket(id, amount)
{
  const xhttp = new XMLHttpRequest();
  xhttp.onload = on_response_html;
  xhttp.open("GET", "common/update_basket.php?product_id="+id+"&amount="+amount);
  xhttp.send();	
}

function on_response_html()
{
	basket = document.getElementById("basket");
	basket.innerHTML = this.responseText;
}
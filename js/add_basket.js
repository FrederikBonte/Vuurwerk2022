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

function on_response_json()
{	
	let data = JSON.parse(this.responseText);
	basket = document.getElementById("basket");
	basket.innerHTML = null;
//	addElement(demo, "span", this.responseText);
	for (i=0;i<data.length;i++)
	{
		let product = addElement(basket, "div", "Aantal : "+data[i]['number']);
//		addElement(product, "br");
		addAttribute(product, "id", data[i]['id']);
	}
//    document.getElementById("demo").innerHTML = this.responseText;
}

function addElement(parent, tag_name, text_content = null)
{
	let node = document.createElement(tag_name);	
	if (text_content!=null)
	{
		let textnode = document.createTextNode(text_content);
		node.appendChild(textnode);
	}
	parent.appendChild(node);
	return node;
}

function addAttribute(parent, attr_name, attr_value = null)
{
	let attr = document.createAttribute(attr_name);	
	if (attr_value!=null)
	{
		attr.value = attr_value;
	}
	parent.setAttributeNode(attr);
}

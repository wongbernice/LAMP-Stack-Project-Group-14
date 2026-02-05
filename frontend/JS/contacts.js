// JavaScript file for ADD, EDIT, DELETE, AND SEARCH
const urlBase = 'http://157.245.13.179/api/contacts'; 

function addContact()
{
  const data = {
    firstName: document.getElementById("firstName").value,
    lastName:  document.getElementById("lastName").value,
    phone:     document.getElementById("phone").value,
    email:     document.getElementById("email").value,
    userId:    userId
  };

  fetch(urlBase + "/add.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data)
  })
  .then(res => res.json())
  .then(json => {
    if (json.error !== "") {
      alert(json.error);
    } else {
      loadContacts(); 
    }
  });
}

function editContact(contactId)
{
  const data = {
    id: contactId,
    firstName: document.getElementById("firstName").value,
    lastName:  document.getElementById("lastName").value,
    phone:     document.getElementById("phone").value,
    email:     document.getElementById("email").value,
    userId:    userId
  };

  fetch(urlBase + "/edit.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(data)
  })
  .then(res => res.json())
  .then(json => {
    if (json.error !== "") {
      alert(json.error);
    } else {
      loadContacts();
    }
  });
}

function deleteContact(contactId)
{
  fetch(urlBase + "/delete.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({
      id: contactId,
      userId: userId
    })
  })
  .then(res => res.json())
  .then(json => {
    if (json.error !== "") {
      alert(json.error);
    } else {
      loadContacts();
    }
  });
}


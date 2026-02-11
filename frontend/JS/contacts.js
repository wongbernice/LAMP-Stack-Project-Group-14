
// READ
// contacts.js (updated: modal supports first/last/phone/email + reliable modal close + no alert boxes)

// IMPORTANT: do NOT name this urlBase because code.js already has urlBase.
// If both load on the same page, you'll get "Identifier 'urlBase' has already been declared".
const contactsUrlBase = "http://157.245.13.179/api/contacts";

document.addEventListener("DOMContentLoaded", () => {
  // make sure the user is actually logged in userId cookie set, otherwise return them to login
  if (typeof readCookie === "function") readCookie();
  if (typeof userId === "undefined" || Number(userId) < 1) {
    window.location.href = "login.html";
    return;
  }

  // elements
  const logoutBtn = document.getElementById("logoutBtn");

  const openAddBtn = document.getElementById("openAddBtn");
  const modalBackdrop = document.getElementById("modalBackdrop");
  const closeModalBtn = document.getElementById("closeModalBtn");
  const cancelBtn = document.getElementById("cancelBtn");
  const contactForm = document.getElementById("contactForm");

  // modal inputs these must match contacts.html ids
  const firstNameInput = document.getElementById("firstName");
  const lastNameInput = document.getElementById("lastName");
  const phoneInput = document.getElementById("phone");
  const emailInput = document.getElementById("email");

  const searchInput = document.getElementById("searchInput");
  const searchBtn = document.getElementById("searchBtn");
  const resultCount = document.getElementById("resultCount");

  // enable search once logged in
  if (searchInput) searchInput.disabled = false;
  if (searchBtn) searchBtn.disabled = false;

  // logout
  if (logoutBtn) logoutBtn.addEventListener("click", doLogout);

  // modal open/close events
  if (openAddBtn) openAddBtn.addEventListener("click", openModal);
  if (closeModalBtn) closeModalBtn.addEventListener("click", closeModal);
  if (cancelBtn) cancelBtn.addEventListener("click", closeModal);

  // clicking outside closes modal
  if (modalBackdrop) {
    modalBackdrop.addEventListener("click", (e) => {
      if (e.target === modalBackdrop) closeModal();
    });
  }

  // escape key closes modal
  document.addEventListener("keydown", (e) => {
    if (e.key === "Escape" && modalBackdrop && modalBackdrop.hidden === false) {
      closeModal();
    }
  });

  // submitting modal form calls add.php
  if (contactForm) {
    contactForm.addEventListener("submit", (e) => {
      e.preventDefault();
      addContactFromModal();
    });
  }

  // search button + pressing enter both run search
  if (searchBtn) {
    searchBtn.addEventListener("click", () => {
      searchContacts((searchInput?.value || "").trim());
    });
  }

  if (searchInput) {
    searchInput.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        e.preventDefault();
        searchContacts(searchInput.value.trim());
      }
    });
  }

  // initial load
  searchContacts("");
});

// Modal helpers
function openModal() {
  const modalBackdrop = document.getElementById("modalBackdrop");
  const firstNameInput = document.getElementById("firstName");
  const lastNameInput = document.getElementById("lastName");
  const phoneInput = document.getElementById("phone");
  const emailInput = document.getElementById("email");

  if (!modalBackdrop) return;

  modalBackdrop.hidden = false;

  if (firstNameInput) firstNameInput.value = "";
  if (lastNameInput) lastNameInput.value = "";
  if (phoneInput) phoneInput.value = "";
  if (emailInput) emailInput.value = "";

  if (firstNameInput) firstNameInput.focus();
}

function closeModal() {
  const modalBackdrop = document.getElementById("modalBackdrop");
  if (!modalBackdrop) return;
  modalBackdrop.hidden = true;
}

// API CALLS
function addContactFromModal() {
  const firstName = document.getElementById("firstName")?.value.trim() || "";
  const lastName = document.getElementById("lastName")?.value.trim() || "";
  const phone = document.getElementById("phone")?.value.trim() || "";
  const email = document.getElementById("email")?.value.trim() || "";

  // add.php requires: userId, firstName, lastName
  if (!firstName || !lastName) return;

  const payload = {
    userId: userId,
    firstName: firstName,
    lastName: lastName,
    phone: phone,
    email: email
  };

  fetch(contactsUrlBase + "/add.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify(payload)
  })
    .then((res) => res.json())
    .then((json) => {
      if (json.error && json.error !== "") {
        console.error("Add contact error:", json.error);
        return;
      }

      closeModal();

      const q = document.getElementById("searchInput")?.value.trim() || "";
      searchContacts(q);
    })
    .catch((err) => {
      console.error("Network error while adding contact.", err);
    });
}

function searchContacts(query) {
  const contactsTbody = document.getElementById("contactsTbody");
  const resultCount = document.getElementById("resultCount");

  if (contactsTbody) {
    contactsTbody.innerHTML = `
      <tr>
        <td class="muted">Loading...</td>
        <td class="actions"><button class="btn btn--secondary" type="button" disabled>Edit</button></td>
      </tr>
    `;
  }
  if (resultCount) resultCount.textContent = "—";

  fetch(contactsUrlBase + "/search.php", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ search: query, userId: userId })
  })
    .then((res) => res.json())
    .then((json) => {
      if (json.error && json.error !== "") {
        renderNoContacts(json.error);
        return;
      }

      const results = Array.isArray(json.results) ? json.results : [];
      renderContacts(results);
    })
    .catch((err) => {
      console.error("Network error while searching.", err);
      renderNoContacts("Network error while searching.");
    });
}

// Rendering
function renderNoContacts(message) {
  const contactsTbody = document.getElementById("contactsTbody");
  const resultCount = document.getElementById("resultCount");

  if (contactsTbody) {
    contactsTbody.innerHTML = `
      <tr>
        <td class="muted">${escapeHtml(message || "No contacts yet")}</td>
        <td class="actions"><button class="btn btn--secondary" type="button" disabled>Edit</button></td>
      </tr>
    `;
  }
  if (resultCount) resultCount.textContent = "0";
}

function renderContacts(names) {
  const contactsTbody = document.getElementById("contactsTbody");
  const resultCount = document.getElementById("resultCount");

  if (!names || names.length === 0) {
    renderNoContacts("No contacts yet");
    return;
  }

  const rows = names
    .map((name) => {
      const safeName = escapeHtml(String(name));
      return `
        <tr>
          <td>${safeName}</td>
          <td class="actions">
            <button class="btn btn--secondary" type="button" disabled>Edit</button>
          </td>
        </tr>
      `;
    })
    .join("");

  if (contactsTbody) contactsTbody.innerHTML = rows;
  if (resultCount) resultCount.textContent = `${names.length}`;
}

// LOGOUT
function doLogout() {
  document.cookie = "firstName=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
  document.cookie = "lastName=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
  document.cookie = "userId=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
  document.cookie = "firstName=,lastName=,userId=;expires=Thu, 01 Jan 1970 00:00:00 GMT";

  window.location.href = "login.html";
}

// UTILITIES
function escapeHtml(str) {
  return String(str)
    .replaceAll("&", "&amp;")
    .replaceAll("<", "&lt;")
    .replaceAll(">", "&gt;")
    .replaceAll('"', "&quot;")
    .replaceAll("'", "&#039;");
}

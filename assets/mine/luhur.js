function getCookie(name) {
  const cookies = document.cookie.split(";");
  for (let i = 0; i < cookies.length; i++) {
    let cookie = cookies[i].trim();
    // Does this cookie string begin with the name we want?
    if (cookie.startsWith(name + "=")) {
      return cookie.substring(name.length + 1);
    }
  }
  return null;
}

function delCookie(name) {
  document.cookie = name + "=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
}

function setCookieJson(name, jsonData, expirationDays) {
  const jsonString = JSON.stringify(jsonData);
  const encodedValue = encodeURIComponent(jsonString); // URL-encode
  let expires = "";
  if (expirationDays) {
    const date = new Date();
    date.setTime(date.getTime() + expirationDays * 24 * 60 * 60 * 1000);
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie = name + "=" + encodedValue + expires + "; path=/";
}

function number_format(number, decimals, dec_point, thousands_sep) {
  // Strip all characters but numerical ones.
  number = (number + "").replace(/[^0-9+\-Ee.]/g, "");
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
    dec = typeof dec_point === "undefined" ? "." : dec_point,
    s = "",
    toFixedFix = function (n, prec) {
      var k = Math.pow(10, prec);
      return "" + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || "").length < prec) {
    s[1] = s[1] || "";
    s[1] += new Array(prec - s[1].length + 1).join("0");
  }
  return s.join(dec);
}

function checkboxArray(name) {
  const checkedCheckboxes = document.querySelectorAll(
    "input[name=" + name + "]:checked"
  );
  const values = Array.from(checkedCheckboxes).map(
    (checkbox) => checkbox.value
  );
  return values;
}

function is_numeric(value) {
  try {
    if (isNaN(value)) {
      return false;
    }
    return true;
  } catch (error) {
    return false;
  }
}

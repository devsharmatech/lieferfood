const localeslg = [
  "en-GB",
  "ar-SA",
  "zh-CN",
  "de-DE",
  "es-ES",
  "fr-FR",
  "hi-IN",
  "it-IT",
  "in-ID",
  "ja-JP",
  "ko-KR",
  "nl-NL",
  "no-NO",
  "pl-PL",
  "pt-BR",
  "sv-SE",
  "fi-FI",
  "th-TH",
  "tr-TR",
  "uk-UA",
  "vi-VN",
  "ru-RU",
  "he-IL",
];

function getFlagSrc(countryCode) {
  return /^[A-Z]{2}$/.test(countryCode)
    ? `https://flagsapi.com/${countryCode.toUpperCase()}/shiny/64.png`
    : "";
}

const dropdownBtnlg = document.getElementById("dropdown-btn-lg");
const dropdownContentlg = document.getElementById("dropdown-content-lg");

function setSelectedLocalelg(locale) {
  const intlLocale = new Intl.Locale(locale);
  const langName = new Intl.DisplayNames([locale], {
    type: "language",
  }).of(intlLocale.language);

  dropdownContentlg.innerHTML = "";

  const otherlocaleslg = localeslg.filter((loc) => loc !== locale);
  otherlocaleslg.forEach((otherLocale) => {
    const otherIntlLocale = new Intl.Locale(otherLocale);
    const otherLangName = new Intl.DisplayNames([otherLocale], {
      type: "language",
    }).of(otherIntlLocale.language);

    const listEl = document.createElement("li");
    listEl.innerHTML = `${otherLangName}<img src="${getFlagSrc(
      otherIntlLocale.region
    )}" />`;
    listEl.value = otherLocale;
    listEl.addEventListener("mousedown", function () {
      setSelectedLocale(otherLocale);
    });
    dropdownContentlg.appendChild(listEl);
  });

  dropdownBtnlg.innerHTML = `<img src="${getFlagSrc(
    intlLocale.region
  )}" />${langName}<span class="arrow-down"></span>`;
}

setSelectedLocalelg(localeslg[0]);
const browserLanglg = new Intl.Locale(navigator.language).language;
for (const locale of localeslg) {
  const localeLanglg = new Intl.Locale(locale).language;
  if (localeLanglg === browserLanglg) {
    setSelectedLocalelg(locale);
  }
}

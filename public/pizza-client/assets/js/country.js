const localesLns = [
    {
        locale: "en-GB",
        country: "United Kingdom",
        region: "GB",
    },

    {
        locale: "de-DE",
        country: "Germany",
        region: "DE",
    },
    {
        locale: "es-ES",
        country: "Spain",
        region: "ES",
    },
    {
        locale: "fr-FR",
        country: "France",
        region: "FR",
    },

    {
        locale: "it-IT",
        country: "Italy",
        region: "IT",
    },
    
    {
        locale: "nl-NL",
        country: "Netherlands",
        region: "NL",
    },
    {
        locale: "no-NO",
        country: "Norway",
        region: "NO",
    },
    {
        locale: "pl-PL",
        country: "Poland",
        region: "PL",
    },
    {
        locale: "pt-BR",
        country: "Brazil",
        region: "BR",
    },
    {
        locale: "fi-FI",
        country: "Finland",
        region: "FI",
    },
    {
        locale: "ru-RU",
        country: "Russia",
        region: "RU",
    },
    
];

$(document).ready(function () {
    const half = Math.ceil(localesLns.length);
    const firstHalf = localesLns.slice(0, half);
    const secondHalf = localesLns.slice(half);

    firstHalf.forEach((locale) => {
        $("#country-list-1").append(`
    <div class="country-option" data-value="${locale.locale}" data-lang="${
            locale.locale
        }" data-flag="https://flagcdn.com/256x192/${locale.region.toLowerCase()}.png">
        <input type="radio" id="${locale.locale}" name="country" value="${
            locale.locale
        }">
        <label for="${locale.locale}">
            <img src="https://flagcdn.com/256x192/${locale.region.toLowerCase()}.png" alt="${
            locale.country
        }">
            ${locale.country}
        </label>
        <span class="check-icon">&#10003;</span>
    </div>
`);
    });

    secondHalf.forEach((locale) => {
        $("#country-list-2").append(`
    <div class="country-option" data-value="${locale.locale}" data-lang="${
            locale.locale
        }" data-flag="https://flagcdn.com/256x192/${locale.region.toLowerCase()}.png">
        <input type="radio" id="${locale.locale}" name="country" value="${
            locale.locale
        }">
        <label for="${locale.locale}">
            <img src="https://flagcdn.com/256x192/${locale.region.toLowerCase()}.png" alt="${
            locale.country
        }">
            ${locale.country} 
        </label>
        <span class="check-icon">&#10003;</span>
    </div>
`);
    });

    // Load selected country from localStorage
    const storedCountry = localStorage.getItem("selectedCountry");
    if (storedCountry) {
        const selectedCountry = $(
            `.country-option input[value="${storedCountry}"]`
        ).closest(".country-option");
        if (selectedCountry.length) {
            selectedCountry.addClass("selected");
            selectedCountry.find('input[type="radio"]').prop("checked", true);
            const flagSrc = selectedCountry.data("flag");
            $("#currentFlag").attr("src", flagSrc);
            $("#countryLangButton").html(
                `<img src="${flagSrc}" id="currentFlag" alt="Country Flag">`
            );
        }
    }

    // Country selection and storing in localStorage
    $(".country-option").click(function () {
        $(".country-option").removeClass("selected");
        $(this).addClass("selected");
        $(this).find('input[type="radio"]').prop("checked", true);

        const selectedCountry = $(".country-option.selected");
        if (selectedCountry.length) {
            const flagSrc = selectedCountry.data("flag");
            const countryValue = selectedCountry
                .find('input[type="radio"]')
                .val();

            // Update the flag and button
            $("#currentFlag").attr("src", flagSrc);
            $("#countryLangButton").html(
                `<img src="${flagSrc}" id="currentFlag" alt="Country Flag">`
            );

            // Store the selected country in localStorage
            localStorage.setItem("selectedCountry", countryValue);
        }
    });

    // Google Translate Integration
    const googleTranslateElement = document.getElementById(
        "google_translate_element"
    );
    function changeLanguage(selectedLanguage) {
        const translateSelect = googleTranslateElement.querySelector("select");

        if (translateSelect) {
            translateSelect.value = selectedLanguage;
            translateSelect.dispatchEvent(new Event("change"));
        }
    }

    // Language selection and storing in localStorage
    $(".language-option").click(function () {
        $(".language-option").removeClass("selected");
        $(this).addClass("selected");
        $('.language-option input[type="radio"]').prop("checked", false);
        $(this).find('input[type="radio"]').prop("checked", true);

        const selectedLanguage = $(".language-option.selected");
        const selectedLangVal = $(".language-option.selected input");
        if (selectedLangVal.length) {
            const lang = selectedLanguage.data("lang");
            const langValue = selectedLangVal.val();
            localStorage.setItem("selectedLanguage", langValue);
            $("html").attr("lang", langValue);
            changeLanguage(langValue);
            $("#countryLangModal").modal("hide");
        }
    });
});

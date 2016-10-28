var pikadayVars = {
    i18n: {
        pl: {
            previousMonth: 'Poprzedni miesiąc',
            nextMonth: 'Następny miesiąc',
            months: ['Styczeń', 'Luty', 'Marzec', 'Kwiecień', 'Maj', 'Czerwiec', 'Lipiec', 'Sierpień', 'Wrzesień', 'Październik', 'Listopad', 'Grudzień'],
            weekdays: ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'],
            weekdaysShort: ['Nied', 'Pon', 'Wt', 'śr', 'Czw', 'Pią', 'Sob']
        },
        en: {
            previousMonth: 'Previous Month',
            nextMonth: 'Next Month',
            months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            weekdays: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            weekdaysShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
        }
    },
    locale: $('html').attr('lang'),
    pickers: [],
    dateInputs: $("input.dateTime:not(.manually)"),
    config: function (field, locale, defaultDate, onSelect, onOpen) {
        if (typeof defaultDate === 'undefined' || defaultDate === null) {
            defaultDate = moment().toDate();
        }

        if (typeof locale === 'undefined') {
            locale = pikadayVars.locale
        }

        if (typeof onSelect === 'undefined') {
            onSelect = function () {
            };
        }

        if (typeof onOpen === 'undefined') {
            onOpen = function () {
            };
        }

        return {
            field: field,
            i18n: pikadayVars.i18n[locale],
            firstDay: 1,
            format: 'D-M-Y',
            showTime: false,
            defaultDate: defaultDate,
            minDate: moment().toDate(),
            showDaysInNextAndPreviousMonths: true,
            onSelect: onSelect,
            onOpen: onOpen
        }
    },
    init: function () {
        var locale = (typeof pikadayVars.i18n[pikadayVars.locale] == 'undefined') ? 'en' : pikadayVars.locale;
        moment.locale(locale);

        pikadayVars.dateInputs.each(function (index) {
            pikadayVars.dateInputs[index] = new Pikaday(
                pikadayVars.config(pikadayVars.dateInputs[index], locale)
            );
        })
    }
};

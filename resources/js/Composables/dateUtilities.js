import useStringUtilities from "@/Composables/stringUtilities.js";
import isNil from "lodash/isNil";
import { DateTime } from "luxon";

export default function useDateUtilities() {
    const formatDate = (date, locale) => {
        if (isNil(locale)) {
            locale = "fr-BJ"; // Locale pour le Bénin
        }

        const { isEmptyString } = useStringUtilities();

        if (isEmptyString(date)) {
            return;
        }

        return DateTime.fromISO(date).setLocale(locale).toFormat("dd/MM/yyyy");
    };

    const dateForHumans = (date, locale = "fr") => {
        if (isNil(locale)) {
            locale = "fr-BJ"; // Locale pour le Bénin
        }

        const { isEmptyString } = useStringUtilities();

        if (isEmptyString(date)) {
            return;
        }

        return DateTime.fromISO(date)
            .setLocale(locale)
            .toFormat("dd/MM/yyyy à HH:mm");
    };

    const currentDateTime = (zone = "Africa/Porto-Novo") => {
        return DateTime.now().setZone(zone).toFormat("yyyy-MM-dd'T'HH:mm:ss");
    };

    const formatTime = (date, locale = "fr") => {
        if (isNil(locale)) {
            locale = "fr";
        }

        return DateTime.fromISO(date).setLocale(locale).toFormat("HH:mm");
    };

    return { formatDate, dateForHumans, formatTime, currentDateTime };
}


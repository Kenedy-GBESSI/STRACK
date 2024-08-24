import isNil from "lodash/isNil";

export default function useStringUtilities() {
    const isEmptyString = (stringToCheck) => {
        return (
            isNil(stringToCheck) ||
            (typeof stringToCheck === "string" &&
                stringToCheck.trim().length === 0)
        );
    };

    const truncateText = (textToTruncate, limit = 50) => {

        if (isEmptyString(textToTruncate)) {
            return;
        }

        let convertedTextToTruncate = textToTruncate;
        if (typeof textToTruncate !== "string") {
            convertedTextToTruncate = textToTruncate.toString();
        }

        if (convertedTextToTruncate.length <= limit) {
            return convertedTextToTruncate;
        }

        return convertedTextToTruncate.slice(0, limit) + "...";
    };

    return { isEmptyString , truncateText};
}

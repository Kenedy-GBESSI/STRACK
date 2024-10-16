<template>
    <div>
        <div
            v-if="selectedFile"
            class="w-full max-h-[20vh] overflow-auto no-scrollbar"
        >
            <h2 class="text-lg font-semibold pb-0.5">Fichier</h2>
            <table class="w-full border-collapse">
                <tr v-for="row in excelData" :key="row">
                    <td
                        v-for="(col, colIndex) in headers"
                        :key="colIndex"
                        class="border p-2 border-[#ddd]"
                    >
                        {{ row[colIndex] || "" }}
                    </td>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
import * as XLSX from "xlsx";

export default {
    props: {
        selectedFile: {
            type: File,
            required: true,
        },
    },

    data() {
        return {
            excelData: null,
            headers: [],
        };
    },

    watch: {
        selectedFile: {
            deep: true,
            handler(newFile) {
                this.$emit(this.excelData);
                this.handleFileChange(newFile);
            },
        },
    },

    mounted() {
        this.handleFileChange(this.selectedFile);
    },

    methods: {
        handleFileChange(file) {
            if (file === null) {
                return;
            }

            const reader = new FileReader();

            function excelSerialToJSDate(serial) {
                var utc_days = Math.floor(serial - 25569);
                var utc_value = utc_days * 86400;
                var date_info = new Date(utc_value * 1000);

                var fractional_day = serial - Math.floor(serial) + 0.0000001;

                var total_seconds = Math.floor(86400 * fractional_day);

                var seconds = total_seconds % 60;

                total_seconds -= seconds;

                var hours = Math.floor(total_seconds / (60 * 60));
                var minutes = Math.floor(total_seconds / 60) % 60;

                return (
                    date_info.getFullYear() +
                    "-" +
                    (date_info.getMonth() + 1) +
                    "-" +
                    date_info.getDate() +
                    " " +
                    hours +
                    ":" +
                    minutes +
                    ":" +
                    seconds
                );
            }

            reader.onload = (e) => {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, { type: "array" });
                const sheetName = workbook.SheetNames[0];
                const sheet = workbook.Sheets[sheetName];
                const jsonData = XLSX.utils.sheet_to_json(sheet, { header: 1 });

                // Generate headers if the first row does not contain headers
                const maxColumns = Math.max(
                    ...jsonData.map((row) => row.length)
                );
                const headers = [];
                for (let i = 0; i < maxColumns; i++) {
                    headers.push(`Column ${i + 1}`);
                }
                this.headers = headers;

                var dateColumns = [];
                var firstRow = jsonData[0];

                Object.keys(firstRow).forEach(function (key) {
                    if (
                        firstRow[key] !== null &&
                        firstRow[key] !== undefined &&
                        !Number.isInteger(firstRow[key])
                    ) {
                        if (firstRow[key].toLowerCase().includes("date")) {
                            dateColumns.push(parseInt(key));
                        }
                    }
                });

                jsonData.forEach(function (row) {
                    dateColumns.forEach(function (columnIndex) {
                        if (!isNaN(row[columnIndex])) {
                            row[columnIndex] = excelSerialToJSDate(
                                row[columnIndex]
                            );
                        }
                    });
                });

                this.excelData = jsonData;
            };

            reader.readAsArrayBuffer(file);
        },

        getColumns() {
            return this.excelData.length > 0
                ? Object.keys(this.excelData[0])
                : [];
        },
    },
};
</script>

<style scoped>
.no-scrollbar {
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.no-scrollbar::-webkit-scrollbar {
    display: none;
}
</style>

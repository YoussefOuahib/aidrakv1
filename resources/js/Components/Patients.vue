<template>
    <div>
        <v-text-field
            return-object
            :counter="25"
            clearable
            append-inner-icon="mdi-magnify"
            :label="$t('message.search')"
            required
            v-model="searching"
        ></v-text-field>
        <v-btn color="primary" class="ml-2" prepend-icon="mdi-account-plus">
            {{ $t("message.addPatient") }}

            <v-dialog v-model="dialog" activator="parent">
                <v-form
                    @submit.prevent="storePatients(patient)"
                    enctype="multipart/form-data"
                >
                    <v-card>
                        <v-card-text>
                            <v-container>
                                <v-row>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field
                                            density="compact"
                                            label="CIN*"
                                            hint="EE82XXXX"
                                            required
                                            v-model="patient.cin"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field
                                            density="compact"
                                            label="Full Name*"
                                            v-model="patient.full_name"
                                            hint="Hakim Ziyech"
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-radio-group
                                            density="compact"
                                            v-model="patient.gender"
                                            inline
                                        >
                                            <v-radio
                                                color="primary"
                                                label="M"
                                                value="m"
                                            ></v-radio>
                                            <v-radio
                                                label="F"
                                                value="f"
                                                color="primary"
                                            ></v-radio>
                                        </v-radio-group>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-text-field
                                            density="compact"
                                            label="Phone*"
                                            hint="066125XXXX"
                                            v-model="patient.phone"
                                            required
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <Datepicker
                                            density="compact"
                                            v-model="patient.birth_date"
                                            :enableTimePicker="false"
                                            :flow="flow"
                                            :max-date="new Date()"
                                            placeholder="Select Birth Date"
                                        ></Datepicker>
                                    </v-col>
                                    <v-col cols="12" sm="6" md="4">
                                        <v-select
                                            :items="insurances"
                                            v-model="patient.insurance"
                                            :label="$t(`message.insurance`)"
                                            density="compact"
                                        ></v-select>
                                    </v-col>
                                </v-row>
                            </v-container>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="blue-darken-1"
                                variant="text"
                                @click="dialog = false"
                            >
                                {{ $t("message.close") }}
                            </v-btn>
                            <v-btn
                                color="blue-darken-1"
                                variant="text"
                                @click="dialog = false"
                                type="submit"
                            >
                                {{ $t("message.save") }}
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                </v-form>
            </v-dialog>
        </v-btn>
        <v-btn
            color="darkPrimary"
            class="ml-2"
            prepend-icon="mdi-printer"
            >{{ $t("message.generateInvoice") }}</v-btn
        >
        <v-table>
            <thead>
                <tr>
                    <th>{{ $t("message.name") }}</th>
                    <th>CIN</th>
                    <th>Age</th>
                    <th>{{ $t("message.phone") }}</th>
                    <th>{{ $t("message.firstAppointment") }}</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="patient in patients.data" :key="patient.id">
                    <td>
                        <v-chip
                            :color="
                                patient.gender == 'm'
                                    ? 'secondary-darken-1'
                                    : 'pink'
                            "
                            text-color="white"
                            :prepend-icon="
                                patient.gender == 'm'
                                    ? 'mdi-gender-male'
                                    : 'mdi-gender-female'
                            "
                            class="font-weight-medium"
                        >
                            {{ patient.full_name }}
                        </v-chip>
                    </td>
                    <td>
                        <v-chip
                            color="darkPrimary"
                            prepend-icon="mdi-account-details"
                            >{{ patient.cin }}</v-chip
                        >
                    </td>
                    <td>
                        <v-chip
                            color="darkPrimary"
                            text-color="white"
                            prepend-icon="mdi-cake-variant"
                            class="font-weight-medium"
                        >
                            {{ patient.age }} {{ $t("message.yearsOld") }}
                        </v-chip>
                    </td>

                    <td>
                        <v-chip
                            color="darkPrimary"
                            text-color="white"
                            prepend-icon="mdi-cellphone"
                            class="font-weight-medium"
                        >
                            {{ patient.phone }}
                        </v-chip>
                    </td>

                    <td>
                        <v-chip
                            color="darkPrimary"
                            text-color="white"
                            prepend-icon="mdi-calendar-range"
                            class="font-weight-medium"
                        >
                            {{ patient.first_app }}
                        </v-chip>
                    </td>

                    <td>
                        <v-btn
                            @click.stop="dialogApp[patient.id] = true"
                            color="warning"
                            class="ml-2"
                            icon="mdi-calendar-range"
                            size="x-small"
                        >
                        </v-btn>
                        <v-btn
                            color="secondary"
                            icon="mdi-calendar-edit"
                            size="x-small"
                            class="ml-2"
                            @click.prevent="getPatient(patient.id)"
                            rounded
                        >
                            <v-icon> </v-icon>
                            <v-dialog
                                v-model="dialogPatient"
                                activator="parent"
                            >
                                <v-form
                                    @submit.prevent="updatePatient(myPatient)"
                                    enctype="multipart/form-data"
                                >
                                    <v-card>
                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col
                                                        cols="12"
                                                        sm="6"
                                                        md="4"
                                                    >
                                                        <v-text-field
                                                            density="compact"
                                                            label="CIN*"
                                                            hint="EE82XXXX"
                                                            required
                                                            v-model="
                                                                myPatient.cin
                                                            "
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col
                                                        cols="12"
                                                        sm="6"
                                                        md="4"
                                                    >
                                                        <v-text-field
                                                            density="compact"
                                                            label="Full Name*"
                                                            v-model="
                                                                myPatient.full_name
                                                            "
                                                            hint="Hakim Ziyech"
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col
                                                        cols="12"
                                                        sm="6"
                                                        md="4"
                                                    >
                                                        <v-radio-group
                                                            density="compact"
                                                            v-model="
                                                                myPatient.gender
                                                            "
                                                            inline
                                                        >
                                                            <v-radio
                                                                color="primary"
                                                                label="M"
                                                                value="m"
                                                            ></v-radio>
                                                            <v-radio
                                                                label="F"
                                                                value="f"
                                                                color="primary"
                                                            ></v-radio>
                                                        </v-radio-group>
                                                    </v-col>
                                                    <v-col
                                                        cols="12"
                                                        sm="6"
                                                        md="4"
                                                    >
                                                        <v-text-field
                                                            density="compact"
                                                            label="Phone*"
                                                            hint="066125XXXX"
                                                            v-model="
                                                                myPatient.phone
                                                            "
                                                            required
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col
                                                        cols="12"
                                                        sm="6"
                                                        md="4"
                                                    >
                                                        <v-select
                                                            :items="insurances"
                                                            v-model="
                                                                myPatient.insurance
                                                            "
                                                            :label="
                                                                $t(
                                                                    `message.insurance`
                                                                )
                                                            "
                                                            density="compact"
                                                        ></v-select>
                                                    </v-col>
                                                    <v-col
                                                        cols="12"
                                                        sm="6"
                                                        md="4"
                                                    >
                                                        <Datepicker
                                                            density="compact"
                                                            v-model="
                                                                myPatient.birth_date
                                                            "
                                                            :enableTimePicker="
                                                                false
                                                            "
                                                            :flow="flow"
                                                            placeholder="Select Birth Date"
                                                        ></Datepicker>
                                                    </v-col>
                                                </v-row>
                                            </v-container>
                                        </v-card-text>
                                        <v-card-actions>
                                            <v-btn
                                                type="submit"
                                                color="darkPrimary"
                                            >
                                                {{ $t("message.save") }}
                                            </v-btn>
                                            <v-btn
                                                color="danger"
                                                @click="dialogPatient = false"
                                            >
                                                {{ $t("message.close") }}</v-btn
                                            >
                                        </v-card-actions>
                                    </v-card>
                                </v-form>
                            </v-dialog>
                        </v-btn>
                        <v-btn
                            color="danger"
                            class="ml-2"
                            icon="mdi-account-minus"
                            size="x-small"
                            v-if="can('patients.delete')"
                            @click.prevent="deletePatient(patient.id)"
                        >
                        </v-btn>
                    </td>
                    <v-dialog v-model="dialogApp[patient.id]" :key="patient.id">
                        <v-card>
                            <v-timeline>
                                <v-timeline-item
                                    v-for="app in patient.appointments"
                                    :key="app.id"
                                    size="large"
                                    dot-color="primary"
                                >
                                    <div>
                                        <v-chip
                                            color="darkPrimary"
                                            prepend-icon="mdi-calendar-range"
                                            class="p-2 font-weight-bold"
                                            size="normal"
                                            >{{ app.date }}
                                        </v-chip>
                                        <v-chip
                                            color="danger"
                                            prepend-icon="mdi-hospital-box"
                                            class="font-weight-medium"
                                            >{{ app.condition }}</v-chip
                                        >
                                        <v-chip
                                            class="font-weight-bold"
                                            prepend-icon="mdi-bottle-tonic-plus"
                                            color="warning"
                                        >
                                            {{ app.medical_treatment }}
                                        </v-chip>
                                        <v-chip
                                            color="info"
                                            prepend-icon="mdi-alert"
                                            class="ml-2"
                                            v-if="app.note"
                                        >
                                            {{ app.note }}</v-chip
                                        >

                                        
                                        <br />
                                    </div>
                                </v-timeline-item>
                            </v-timeline>
                            <v-card-actions>
                                <v-btn
                                    color="darkPrimary"
                                    block
                                    @click.stop="dialogApp[patient.id] = false"
                                >
                                    {{ $t("message.close") }}</v-btn
                                >
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </tr>
            </tbody>
        </v-table>
        <v-dialog v-model="dialogInvoice" activator="parent">
            <v-card>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12" sm="6" md="6">
                                <v-select
                                    v-model="invoice.patient_id"
                                    :items="patients.data"
                                    label="Patient"
                                    item-title="full_name"
                                    item-value="id"
                                    @update:modelValue="getPatient"
                                >
                                </v-select>
                            </v-col>
                            <v-col cols="12" sm="6" md="6">
                                <v-text-field
                                    label="Bill to"
                                    v-model="invoice.billTo"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12" md="12">
                                <v-text-field
                                    label="address"
                                    v-model="invoice.address"
                                >
                                </v-text-field>
                            </v-col>
                            <v-col cols="12" sm="12" md="12">
                                <v-table>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Patient</th>
                                            <th>Act</th>
                                            <th>Rate</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="app in myPatient.appointments"
                                            :key="app.id"
                                        >
                                            <td>
                                                <v-checkbox
                                                    v-model="
                                                        selectedAppointments
                                                    "
                                                    :value="app"
                                                    class="mt-5"
                                                ></v-checkbox>
                                            </td>
                                            <td>
                                                {{ app.patient_name }}
                                            </td>
                                            <td>
                                                <v-chip color="danger">
                                                    {{ app.condition }}
                                                </v-chip>
                                            </td>
                                            <td>{{ app.rate }} MAD</td>
                                            <td>
                                                {{ app.date }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </v-table>
                            </v-col>
                        </v-row>
                    </v-container>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn
                        @click="
                            exportToPDF(
                                myPatient.full_name,
                                myPatient.id,
                                settings,
                                selectedAppointments
                            )
                        "
                        color="darkPrimary"
                    >
                        Print
                    </v-btn>
                    <v-btn
                        color="blue-darken-1"
                        variant="text"
                        @click="dialogInvoice = false"
                    >
                        {{ $t("message.close") }}
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
        <v-pagination
            v-model="current_page"
            :length="last_page"
            color="primary"
            @update:modelValue="onPageChange"
        ></v-pagination>
    </div>
</template>

<script>
import { reactive, onMounted, ref, watch } from "vue";
import usePatients from "../Composables/patients";
import { useAbility } from "@casl/vue";
import Datepicker from "@vuepic/vue-datepicker";
import pdfMake from "pdfmake";
import pdfFonts from "pdfmake/build/vfs_fonts";
import useSettings from "../Composables/settings";

export default {
    components: { Datepicker },
    data: () => ({
        dialog: false,
        dialogPatient: false,
        dialogInvoice: false,
        dialogApp: {},
        rules: {
            required: (value) => !!value || "Required.",
            counter: (value) => value.length <= 20 || "Max 20 characters",
        },
    }),
    setup() {
        const searching = ref("");
        const patient = reactive({
            full_name: "",
            phone: "",
            cin: "",
            gender: "",
            birth_date: new Date(),
            insurance: "",
        });
        const insurances = ref([
            "CNSS",
            "CNOPS",
            "OCP",
            "FAR",
            localStorage.getItem("userLanguage") == "en" ? "Other" : "Autre",
        ]);
        const selectedAppointments = ref([]);

        const invoice = reactive({
            patient_id: "",
            billTo: "",
            address: "",
        });

        const { can } = useAbility();
        const flow = ref(["year", "month", "calendar"]);
        const { getSettings, settings } = useSettings();
        const {
            patients,
            myPatient,
            getPatients,
            getPatient,
            updatePatient,
            storePatients,
            searchPatients,
            deletePatient,
            current_page,
            last_page,
        } = usePatients();

        const exportToPDF = (name, id, settings, apps) => {
            let data = [];
            let rows = [["Acte Médical", "Prix", "Date"]];
            let prices = [];
            let total = 0;
            const current = new Date();
            const currentDate = `${current.getDate()}/${
                current.getMonth() + 1
            }/${current.getFullYear()}`;
      

            apps.forEach(function (value, key) {
                data.push({
                    condition: value.condition,
                    rate: value.rate,
                    date: value.date,
                });
                prices.push(value.rate);
            });
            total = prices.reduce(function (previousValue, currentValue) {
                return previousValue + currentValue;
            });

            data.forEach(function (value, key) {
                rows.push([value.condition, value.rate + " MAD", value.date]);
            });

            const documentDefinition = {
                content: [
                    {
                        alignment: "left",
                        text:
                            "Facture Numéro: " +
                            id +
                            Math.floor(Math.random() * 100 + 1),
                        fontSize: 10,
                        bold: true,
                        margin: [0, 10],
                    },
                    {
                        alignment: "left",
                        text: "Date: " + currentDate,
                        fontSize: 10,
                        margin: [0, 2],
                    },
                    {
                        alignment: "left",
                        text: settings.Name,
                        fontSize: 14,
                        bold: true,
                        margin: [0, 4],
                    },
                    {
                        alignment: "left",
                        text: settings.speciality,
                        fontSize: 14,
                        margin: [0, 4],
                    },
                    {
                        alignment: "left",
                        text: settings.address,
                        fontSize: 10,
                        margin: [0, 2],
                    },

                    {
                        alignment: "right",
                        text: name,
                        fontSize: 14,
                        bold: true,
                        margin: [0, 10],
                    },
                    {
                        alignment: "right",
                        text: invoice.billTo,
                        fontSize: 12,
                        margin: [0, 2],
                    },
                    {
                        alignment: "right",
                        text: invoice.address,
                        fontSize: 12,
                        margin: [0, 2, 2, 25],
                    },
                    {
                        table: {
                            margin: [50, 15, 15, 25],
                            widths: ["50%", "25%", "25%"],
                            heights: [25, 25],

                            body: rows,
                        },
                    },
                    {
                        alignment: "left",
                        text: "Total: " + total + " MAD",
                        fontSize: 12,
                        margin: [5, 15, 2, 10],
                    },
                ],
            };
            pdfMake.vfs = pdfFonts.pdfMake.vfs;
            pdfMake.createPdf(documentDefinition).open();
        };
        onMounted(() => {
            getPatients();
        });
        const onPageChange = (current_page) => {
            getPatients(current_page);
        };
        watch(searching, (current, previous) => {
            searchPatients(current);
        });

        return {
            getSettings,
            settings,
            invoice,
            searching,
            myPatient,
            patient,
            patients,
            getPatient,
            storePatients,
            updatePatient,
            deletePatient,
            searchPatients,
            getPatients,
            current_page,
            last_page,
            exportToPDF,
            onPageChange,
            insurances,
            flow,
            can,
            selectedAppointments,

        };
    },
};
</script>

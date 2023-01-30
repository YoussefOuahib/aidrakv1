<template>
    <div>
        <v-text-field
            return-object
            :counter="25"
            clearable
            append-inner-icon="mdi-magnify"
            label="Search by name"
            v-model="searching"
            required
        ></v-text-field>

        <v-table>
            <thead>
                <tr>
                    <th>Patient</th>
                    <th>Condition</th>
                    <th>Sessions</th>
                    <th>{{ $t("message.paidAmount") }}</th>
                    <th>{{ $t("message.remainingAmount") }}</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="session in sessions.data" :key="session.id">
                    <td>
                        <v-chip
                            :color="
                                session.patient_gender == 'm'
                                    ? 'secondary-darken-1'
                                    : 'pink'
                            "
                            text-color="white"
                            :prepend-icon="
                                session.patient_gender == 'm'
                                    ? 'mdi-gender-male'
                                    : 'mdi-gender-female'
                            "
                            class="font-weight-medium"
                        >
                            {{ session.patient_name }}
                        </v-chip>
                    </td>
                    <td>
                        <v-chip color="danger" class="font-weight-medium">
                            {{ session.condition }}
                        </v-chip>
                    </td>
                    <td>
                        <v-chip
                            color="darkPrimary"
                            text-color="white"
                            prepend-icon="mdi-timer-sand-full"
                            class="font-weight-medium"
                        >
                            {{ session.total_sessions }}
                        </v-chip>
                        <v-chip
                            color="danger"
                            text-color="white"
                            prepend-icon="mdi-timer-sand"
                            class="font-weight-medium"
                            size="x-small"
                        >
                            -{{ session.remaining_sessions }}
                        </v-chip>
                    </td>
                    <td>
                        <v-chip
                            color="darkPrimary"
                            text-color="white"
                            prepend-icon="mdi-account-cash"
                            class="font-weight-medium"
                        >
                            {{ session.rate }} MAD
                        </v-chip>
                    </td>

                    <td>
                        <v-chip
                            color="darkPrimary"
                            text-color="white"
                            prepend-icon="mdi-cash-multiple"
                            class="font-weight-medium"
                        >
                        {{ session.remaining_amount }} MAD
                        </v-chip>
                        <v-chip
                            color="danger"
                            text-color="white"
                            prepend-icon="mdi-cash-lock"
                            class="font-weight-medium"
                            size="x-small"
                        >
                        {{ session.total_amount }} MAD

                        </v-chip>
                    </td>

                    <td>
                        <v-chip
                            color="darkPrimary"
                            text-color="white"
                            prepend-icon="mdi-calendar-range"
                            class="font-weight-medium"
                        >
                            {{ session.date }}
                        </v-chip>
                    </td>

                    <td>
                        <v-btn
                            @click.prevent="
                                getInfo(session.id, session.patient_id)
                            "
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
                            @click.prevent="editSession(session)"
                            rounded
                        >
                            <v-icon> </v-icon>
                            <v-dialog
                                v-model="dialogSession"
                                activator="parent"
                            >
                                <v-form
                                    @submit.prevent="updateSession(mySession)"
                                    enctype="multipart/form-data"
                                >
                                    <v-card>
                                        <v-card-text>
                                            <v-container>
                                                <v-row>
                                                    <v-col
                                                        v-if="can('appointments.update')"
                                                        cols="12"
                                                        sm="6"
                                                        md="6"
                                                    >
                                                        <v-text-field
                                                            v-model="
                                                                mySession.medical_treatment
                                                            "
                                                            label="Medical Treatment"
                                                            placeholder="Aspirin, ..."
                                                            required
                                                            density="compact"
                                                        ></v-text-field>
                                                    </v-col>
                                                    <v-col
                                                        v-if="
                                                            can(
                                                                'appointments.update'
                                                            )
                                                        "
                                                        cols="12"
                                                        sm="6"
                                                        md="6"
                                                    >
                                                        <v-select
                                                        v-model="mySession.condition"
                                                            density="compact"
                                                            Label="Condition"
                                                            single-line
                                                            chips
                                                            clearable
                                                            :items="
                                                                selectConditions
                                                            "
                                                            item-title="name"
                                                            item-value="id"
                                                        ></v-select>
                                                    </v-col>

                                                    <v-col
                                                        cols="12"
                                                        sm="6"
                                                        md="6"
                                                    >
                                                        <Datepicker
                                                            :enableTimePicker="
                                                                false
                                                            "
                                                            :highlightWeekDays="[
                                                                0, 6,
                                                            ]"
                                                            :minDate="
                                                                new Date()
                                                            "
                                                            no-today
                                                            placeholder="Select next examination date"
                                                            v-model="
                                                                mySession.next_examination_date
                                                            "
                                                        ></Datepicker>
                                                    </v-col>

                                                    <v-col
                                                        v-if="
                                                            can(
                                                                'appointments.update'
                                                            )
                                                        "
                                                        cols="12"
                                                        sm="6"
                                                        md="6"
                                                    >
                                                        <v-text-field
                                                            clearable
                                                            v-model="
                                                                mySession.note
                                                            "
                                                            label="Additional Note"
                                                            density="compact"
                                                        ></v-text-field>
                                                    </v-col>

                                                    <v-col
                                                        v-if="
                                                            mySession.is_paid ==
                                                                'paid' &&
                                                            can(
                                                                'appointments.update'
                                                            )
                                                        "
                                                        cols="12"
                                                        sm="6"
                                                        md="6"
                                                    >
                                                        <v-text-field
                                                            label="Rate"
                                                            density="compact"
                                                            type="numeric"
                                                            v-model="
                                                                mySession.rate
                                                            "
                                                        >
                                                        </v-text-field>
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
                                                @click="dialogSession = false"
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
                            icon="mdi-delete"
                            size="x-small"
                            @click="deleteSession(session.id)"
                        >
                        </v-btn>
                    </td>
                    <v-dialog v-model="dialogApp">
                        <v-card>
                            <v-timeline>
                                <v-timeline-item
                                    v-for="app in myPatient.appointments"
                                    :key="app.id"
                                    size="large"
                                    :dot-color="
                                        app.is_paid == 'paid'
                                            ? 'success'
                                            : 'danger'
                                    "
                                >
                                    <div>
                                        <v-chip
                                            color="darkPrimary"
                                            prepend-icon="mdi-calendar-range"
                                            class="font-weight-bold"
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
                                            v-if="app.note"
                                            color="info"
                                            prepend-icon="mdi-alert"
                                            class="ml-2"
                                        >
                                            {{ app.note }}</v-chip
                                        >

                                        <br />
                                        <v-chip
                                            color="darkPrimary"
                                            prepend-icon="mdi-bed"
                                            class="font-weight-medium ml-2"
                                            size="small"
                                            >{{ app.type }}</v-chip
                                        >
                                        <br />
                                    </div>
                                </v-timeline-item>
                            </v-timeline>
                            <v-card-actions>
                                <v-btn
                                    color="darkPrimary"
                                    @click.stop="dialogApp = false"
                                    >Close Dialog</v-btn
                                >
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </tr>
            </tbody>
        </v-table>
    </div>
</template>
<script>
import { reactive, onMounted, ref, watch} from "vue";
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";

import useSessions from "../Composables/sessions";
import usePatients from "../Composables/patients";
import useConditions from "../Composables/conditions";
import { useAbility } from "@casl/vue";

export default {
    components: { Datepicker },
    data: () => ({
        dialogSession: false,
    }),
    setup() {
        const searching = ref("");
        const dialogApp = ref(false);

        const { getSessions, sessions, getSession, mySession, updateSession, deleteSession, searchSessions } =
            useSessions();
        const { getPatients, patients, myPatient, getPatient } = usePatients();

        const { getConditionsbyPatient, selectConditions } = useConditions();

        onMounted(() => {
            getPatients();
            getSessions();
        });

        const getInfo = (sessionId, patientId) => {
            dialogApp.value = true;
            getSession(sessionId);
            getPatient(patientId);
        };
        const editSession = async (session) => {
             getSession(session.id);
            getConditionsbyPatient(session.patient_id, "session");

        };
        const { can } = useAbility();
        watch(searching, (current, previous) => {
            searchSessions(current);
        });

        return {
            searching,
            getConditionsbyPatient,
            selectConditions,
            getSessions,
            getInfo,
            deleteSession,
            getSession,
            updateSession,
            editSession,
            mySession,
            sessions,
            getPatients,
            myPatient,
            patients,
            getPatient,
            dialogApp,
            can,
        };
    },
};
</script>

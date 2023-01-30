import axios from "axios";
import { ref, inject } from "vue";

export default function useAppointments() {
    const appointments = ref({});
    const dates = ref({});
    const checked = ref(true);
    const myAppointment = ref({});
    const validationErrors = ref({});
    const swal = inject("$swal");
    const getAppointments = async () => {
        axios.get("/api/appointments").then((response) => {
            appointments.value = response.data;
        });
    };
    const getAppointment = async (appointment) => {
        axios.get("/api/appointments/" + appointment).then((res) => {
            myAppointment.value = res.data.data;
        });
    };


    const getNextDates = async () => {
        axios.get("/api/nextdates").then((response) => {
            dates.value = response.data;
        });
    };

    const storeAppointments = async (appointment, calendar) => {

        axios
            .post("/api/appointments", appointment)
            .then((response) => {
                swal({
                    icon: "success",
                    title: localStorage.getItem('userLanguage') == 'en' ? "Saved ! " : "Enregistré !",
                });
                let calendarApi = calendar.getApi();
                calendarApi.refetchEvents();
            })
            .catch((error) => {
                if (error.response?.data) {
                    validationErrors.value = error.response?.data.errors;
                }
            });
    };
    const updateAppointment = async (appointment, calendar) => {
        axios
            .put("/api/appointments/" + appointment.id, appointment)
            .then((response) => {
                swal({
                    icon: "success",
                    title: localStorage.getItem('userLanguage') == 'en' ? "Edited ! " : "Modifié !",
                });

                getAppointment(appointment);
                let calendarApi = calendar.getApi();
                calendarApi.refetchEvents();
            })
            .catch((error) => {
                if (error.response?.data) {
                    validationErrors.value = error.response?.data.errors;
                }
            });
    };

    const deleteAppointment = async (appointment, calendar) => {

        swal({
            title: "Are you sure you wanna delete this appointment?",
            title: localStorage.getItem('userLanguage') == 'en' ? "the future appointments which associated with this appointment will be deleted too !" : "les prochains rendez-vous associés à ce rendez-vous seront également supprimés !",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#499167",
            cancelButtonColor: "#E97777",
            confirmButtonText: "Yes, delete it!",
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .delete("/api/appointments/" + appointment)
                    .then((response) => {
                        swal.fire(
                            localStorage.getItem('userLanguage') == 'en' ? "Deleted" : 'Supprimé',
                            "success"
                        );
                    });
                let calendarApi = calendar.getApi();
                calendarApi.refetchEvents();
            }
        });
    };

    const deleteNextDate = async (appointment, calendar) => {

        swal({
            title:  localStorage.getItem('userLanguage') == 'en' ? "Are you sure you wanna delete this date?" : "Voulez-vous vraiment supprimer cette date ?" ,
            text:  localStorage.getItem('userLanguage') == 'en' ? "you won't be able to restore this information" : "vous ne pourrez pas restaurer ces informations",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#499167",
            cancelButtonColor: "#E97777",
            confirmButtonText:  localStorage.getItem('userLanguage') == 'en' ? "Yes, delete it!" : 'Suprrimez !' ,
        }).then((result) => {
            if (result.isConfirmed) {
                axios
                    .post("/api/nextdates/" + appointment)
                    .then((response) => {
                        let calendarApi = calendar.getApi();
                        calendarApi.refetchEvents();
                        swal.fire(
                            "Deleted!",
                            "Date has been deleted.",
                            "success"
                        );
                    });
               
            }
        });
    };

    const searchAppointments = async (item) => {
        axios
            .get("/api/search/appointments?searching=" + item)
            .then((response) => {
                appointments.value = response.data;
            })
            .catch((error) => console.log(error));
    };

    return {
        getAppointments,
        appointments,
        storeAppointments,
        searchAppointments,
        getNextDates,
        getAppointment,
        myAppointment,
        dates,
        deleteAppointment,
        deleteNextDate,
        updateAppointment,
   
    };
}

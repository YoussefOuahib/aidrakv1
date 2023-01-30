import axios from "axios"
import {ref, inject} from 'vue'

export default function useUpcoming() {
    const swal = inject("$swal");

    const storeUpcomingAppointment = async (appointment, calendar) => {

        axios
            .post("/api/upcomings", appointment)
            .then((response) => {
                swal({
                    icon: "success",
                    title: "Appointment has been saved successfully",
                });
                let calendarApi = calendar.getApi();
                calendarApi.refetchEvents();
            });
    };
    return {
        storeUpcomingAppointment
    }
}
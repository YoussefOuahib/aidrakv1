import axios from "axios";
import { ref, inject } from "vue";

export default function useSettings() {
    const settings = ref({})
    const fixedRate = ref("");
    const swal = inject("$swal");


    const getSettings = async () => {
        axios.get("/api/settings").then((res) => {
            settings.value = res.data;
           fixedRate.value = res.data.rate;
        });
        
    };
    const updateSettings = async (settings) => {
        axios.post('/api/settings', settings).then((response) => {
            swal({
                icon: "success",
                title: "Settings has been saved successfully",
            });
            getSettings();
        })
    }

    return {getSettings, settings, updateSettings, fixedRate}


}
import { ref } from "vue";
import { v4 as uuidv4 } from "uuid";

const alerts = ref([]);

export default function useAlerts() {
    const MAX_NOTIFICATIONS = 5;
    const DEFAULT_DURATION = 7000;

    const removeAlert = (id, duration = null) => {
        if (null === duration) {
            duration = DEFAULT_DURATION;
        }

        setTimeout(() => {
            alerts.value = alerts.value.filter((alert) => alert.id !== id);
        }, duration);
    };

    const addAlert = (alert) => {
        const id = uuidv4();

        alerts.value.push({
            id: id,
            ...alert,
        });

        removeAlert(id, alert.duration);

        if (alerts.value.length > MAX_NOTIFICATIONS) {
            alerts.value = alerts.value.slice(1);
        }
    };

    return {
        alerts,
        addAlert,
        removeAlert,
    };
}

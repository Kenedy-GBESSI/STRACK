export default function useNavigationsData() {
    const navigationsWithChildren = [
        {
            name: "Tableau de bord",
            route: "dashboard",
        },
        {
            name: "Étudiants",
            route: "profile.show",
        },
    ];

    return { navigationsWithChildren };
}

export default function useNavigationsData() {
    const navigationsWithChildren = [
        {
            id: "dashboardx",
            name: "Tableau de bord",
            icon: "fa-light fa-chart-pie",
            current: true,
            route: "dashboard",
        },
        {
            id: "studentx",
            name: "Étudiants",
            icon: "fa-light fa-users",
            current: false,
            route: "profile.show",
        },
    ];

    const userNavigations = [
        {
            name: "Profil",
            route: "profile.show",
            icon: "fa-light fa-house",
            current: false,
        },
    ];

    return { navigationsWithChildren, userNavigations };
}

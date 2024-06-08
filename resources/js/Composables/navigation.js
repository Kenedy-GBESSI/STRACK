import { isArray, isEmpty, isNil, map } from "lodash";

export default function useNavigation() {
    const setCurrentActiveNavigation = (navigationsWithChildren) => {
        navigationsWithChildren.forEach((navigation) => {
            if (hasChildren(navigation)) {
                navigation.current = hasActiveChildOrGrandChild(navigation);
            } else {
                // eslint-disable-next-line no-undef
                navigation.current = route().current(navigation.route);
            }

            return navigation;
        });
    };

    const routeSubstringBeforeDot = (route) => {
        if (isNil(route) || typeof route !== "string") {
            console.error("Route string provided is not a valid string.");
            return;
        }

        // For example, In order to show that the user is still in the "companies"
        // menu for "companies.edit" or "companies.create" route, we take
        // the first part before the dot of the route string to make a comparison.
        return route.substring(0, route.indexOf("."));
    };

    const isActiveGroupRouteFromChildren = (menuItemChildren) => {
        if (isEmpty(menuItemChildren)) {
            return;
        }

        for (const childMenu of menuItemChildren) {
            if (isActiveGroupRoute(childMenu)) {
                return true;
            }
        }

        return false;
    };

    const isActiveGroupRoute = (menuItem) => {
        if (!Object.hasOwn(menuItem, "route")) {
            console.error(
                "Navigation menu item object don't have route property.",
            );
            return;
        }

        let substringBeforeDotFromProvidedRoute = routeSubstringBeforeDot(
            menuItem.route,
        );

        let substringBeforeDotFromCurrentRoute = routeSubstringBeforeDot(
            // eslint-disable-next-line no-undef
            route().current(),
        );

        return typeof substringBeforeDotFromProvidedRoute === "string" &&
            substringBeforeDotFromProvidedRoute.trim() !== ""
            ? substringBeforeDotFromProvidedRoute ===
                  substringBeforeDotFromCurrentRoute
            : false;
    };

    const isAnyChildrenActive = (navigationItemChildren) => {
        if (!isArray(navigationItemChildren)) {
            console.error(
                `navigationItemChildren must be array, ${typeof navigationItemChildren} type provided`,
            );
            return;
        }

        if (isAnyChildrenRouteActiveRoute(navigationItemChildren)) {
            return true;
        }

        for (const childItem of navigationItemChildren) {
            if (!hasChildren(childItem)) {
                continue;
            }

            if (isAnyChildrenActive(childItem.children)) {
                return true;
            }
        }

        return false;
    };

    const isAnyChildrenRouteActiveRoute = (navigationItemChildren = []) => {
        const childrenRoutes = isArray(navigationItemChildren)
            ? map(navigationItemChildren, "route")
            : [];

        return (
            // eslint-disable-next-line no-undef
            childrenRoutes.includes(route().current()) ||
            isActiveGroupRouteFromChildren(navigationItemChildren)
        );
    };

    const isActiveParent = (navigationItem) => {
        if (hasChildren(navigationItem)) {
            return isAnyChildrenActive(navigationItem.children);
        }
        return isActiveRoute(navigationItem);
    };

    const isActiveRoute = (menuItem) => {
        if (!Object.hasOwn(menuItem, "route")) {
            console.error(
                "Navigation menu item object don't have route property or route is undefined or null.",
            );
            return;
        }

        return typeof menuItem.route === "string" &&
            menuItem.route.trim() !== "" // eslint-disable-next-line no-undef
            ? route().current(menuItem.route) || isActiveGroupRoute(menuItem)
            : false;
    };

    const hasActiveChildOrGrandChild = (parentItem) => {
        return isActiveParent(parentItem);
    };

    const gatherProvidedNavigationChildrenRoutes = (navigationItem) => {
        return hasChildren(navigationItem)
            ? map(navigationItem.children, "route")
            : [];
    };

    const hasChildren = (navigationItem) => {
        return Object.hasOwn(navigationItem, "children");
    };

    const keepActiveParentDisclosureOpen = (navigationsWithChildren, refs) => {
        if (isNil(refs)) {
            console.warn(
                "refs is null/undefined, maybe the component is not already mounted.",
            );
        }

        navigationsWithChildren.forEach((navigation) => {
            if (hasChildren(navigation)) {
                if (navigation.current) {
                    for (const element of refs.parentsWithDisclosure) {
                        if (navigation.id === element.$el.id) {
                            element.$el.click();
                        }
                    }
                }
            }
        });
    };

    const isGrandparentNavigation = (menuItem) => {
        if (!hasChildren(menuItem)) {
            return false;
        }

        // We loop over the child of the provided menuItem's children
        // to check if at least one of them has a child
        for (const child of menuItem.children) {
            if (hasChildren(child)) {
                return true;
            }
        }

        return false;
    };

    return {
        gatherProvidedNavigationChildrenRoutes,
        hasActiveChildOrGrandChild,
        hasChildren,
        isActiveGroupRoute,
        isActiveParent,
        isActiveRoute,
        isGrandparentNavigation,
        keepActiveParentDisclosureOpen,
        routeSubstringBeforeDot,
        setCurrentActiveNavigation,
    };
}

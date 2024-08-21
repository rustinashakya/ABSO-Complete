const data = [{
    id: "nep-but",
    location: "nepalgunj",
    title: "Nepalgunj to Base Station",
    routes: {
        airRoute: [{
            label: "air",
            title: "Nepalgunj Airport to Gautam Buddha International Airport",
            description: "25 mins (if available)"
        }, {
            label: "road",
            title: "Gautam Buddha International Airport to Butwal Buspark",
            description: "30 mins"
        }, {
            label: "walk",
            title: "Walk to Base Station",
            description: "25 mins"
        }],
        roadRoute: [{
            label: "road",
            title: "Nepalgunj to Butwal Buspark",
            description: "5 hr 21 mins"
        }, {
            label: "walk",
            title: "Walk to Base Station",
            description: "25 mins"
        }]
    }
}, {
    id: "kat-but",
    location: "kathmandu",
    title: "Kathmandu to Base Station",
    routes: {
        airRoute: [{
            label: "air",
            title: "Tribhuvan Airport to Gautam Buddha International Airport",
            description: "35 mins"
        }, {
            label: "road",
            title: "Gautam Buddha International Airport to Butwal Buspark",
            description: "30 mins"
        }, {
            label: "walk",
            title: "Walk to Base Station",
            description: "25 mins"
        }],
        roadRoute: [{
            label: "road",
            title: "Kathmandu to Butwal Buspark",
            description: "6 hours"
        }, {
            label: "walk",
            title: "Walk to Base Station",
            description: "25 mins"
        }]
    }
}, {
    id: "tan-but",
    location: "tansen",
    title: "Tansen to Base Station",
    routes: {
        roadRoute: [{
            label: "road",
            title: "Tansen to Butwal Buspark",
            description: "1 hr 15 mins"
        }, {
            label: "walk",
            title: "Walk to Base Station",
            description: "25 mins"
        }]
    }
}, {
    id: "pok-but",
    location: "pokhara",
    title: "Pokhara to Base Station",
    routes: {
        airRoute: [{
            label: "air",
            title: "Pokhara Airport to Gautam Buddha International Airport",
            description: "20 mins"
        }, {
            label: "road",
            title: "Gautam Buddha International Airport to Butwal Buspark",
            description: "30 mins"
        }, {
            label: "walk",
            title: "Walk to Base Station",
            description: "25 mins"
        }],
        roadRoute: [{
            label: "road",
            title: "Pokhara to Butwal Buspark",
            description: "5 hr 16 mins"
        }, {
            label: "walk",
            title: "Walk to Base Station",
            description: "25 mins"
        }]
    }
}, {
    id: "lum-cir-but",
    location: "lumbini",
    title: "Lumbini to Base Station",
    routes: {
        // airRoute: [{
        //     label: "air",
        //     title: "Siddhartha Nagar(Bhairahawa) to Gautam Buddha International Airport",
        //     description: "30 mins"
        // }, {
        //     label: "road",
        //     title: "Nepalgunj to Butwal Buspark",
        //     description: "5 hr 19 mins"
        // }, {
        //     label: "walk",
        //     title: "Walk to Base Station",
        //     description: "25 mins"
        // }],
        roadRoute: [{
            label: "road",
            title: "Lumbini to Butwal Buspark (Via Circuit Road)",
            description: "1 hour"
        }, {
            label: "walk",
            title: "Walk to Base Station",
            description: "25 mins"
        }]
    }
}, {
    id: "lum-sid-but",
    location: "lumbini",
    title: "Lumbini to Base Station",
    routes: {
        // airRoute: [{
        //     label: "air",
        //     title: "Siddhartha Nagar(Bhairahawa) to Gautam Buddha International Airport",
        //     description: "30 mins"
        // }, {
        //     label: "road",
        //     title: "Nepalgunj to Butwal Buspark",
        //     description: "5 hr 19 mins"
        // }, {
        //     label: "walk",
        //     title: "Walk to Base Station",
        //     description: "25 mins"
        // }],
        roadRoute: [{
            label: "road",
            title: "Lumbini to Butwal Buspark (Via Bhairahawa)",
            description: "1 hour and 30 mins"
        }, {
            label: "walk",
            title: "Walk to Base Station",
            description: "25 mins"
        }]
    }
}, {
    id: "gor-but",
    location: "gorakhpur",
    title: "Gorakhpur to Base Station",
    routes: {
        roadRoute: [{
            label: "road",
            title: "Gorakhpur to Butwal Buspark",
            description: "5 hours"
        }, {
            label: "walk",
            title: "Butwal Buspark to base station",
            description: "25 mins"
        }]
    }
}, {
    id: "but-base",
    location: "base-station",
    title: "Bus Park to Base Station",
    routes: {
        walkRoute: [{
            label: "walk",
            title: "Butwal Buspark to Base Station",
            description: "25 mins"
        }],
        roadRoute: [{
            label: "road",
            title: "Butwal Buspark to Base Station ",
            description: "5 mins"
        }]
    }
}];

//Get mouse location to set position for route container
const getMouseLocation = (event) => {
    // var center = {x: window.innerWidth/2, y: window.innerHeight/2};
    const map = document.getElementById("map");
    var position = map.getBoundingClientRect();
    var center = {x: (position.width+position.left)/2, y: (position.height+position.top)/2};
    var mouse = {x: event.clientX, y: event.clientY};
    if(mouse.x > center.x && mouse.y > center.y) return "bottomRight";
    if(mouse.x < center.x && mouse.y < center.y) return "topLeft";
    if(mouse.x > center.x && mouse.y < center.y) return "topRight";
    if(mouse.x < center.x && mouse.y > center.y) return "bottomLeft";
}

//Route information
const displayRouteInformation = (e, info) => {
    if(!e || !info) return;
    d3.select("div.infoContainer").remove();
    const desktopPage =document.querySelector('[data-label="desktop-page"]');
    const isDesktopPage = this.getComputedStyle(desktopPage).getPropertyValue("display");
    const mapContainer = isDesktopPage === "none" ? d3.select("#map-mobile") : d3.select("#map");
    const mouseLocation = getMouseLocation(e);
    const id = e.target.id;
    //Route information container and child components
    const infoContainer = mapContainer.append("div").attr("class", "infoContainer")
    .attr("data-label", `info-${id}`);
    const titleContainer = infoContainer.append("div").attr("class", "infoContainer-header");
    titleContainer.append("h3").text(info.title);
    titleContainer.append('img')
    .attr('src', 'assets/frontend/img/close.png').attr("class", "header-close").on("click", function(e){
        d3.selectAll(`div[data-label=info-${id}]`).remove();
    });
    const bodyContainer = infoContainer.append("div").attr("class", "infoContainer-body");
    //Information according to route option i.e. air and road.
    const routeKeys = Object.keys(info.routes);
    routeKeys.forEach(function(key, index) {
        const routeInfo = info.routes[key];
        const routeContainer = bodyContainer.append("div").attr("class", "route-container")
        .attr("data-label", `${key}`);
        if(index === 0) routeContainer.classed("route-container-edits", true);
        //Steps/Direction for each route option
        routeInfo.forEach((path) => {
            const route = routeContainer.append("div").attr("class", "route");
            route.append('img').attr('src', `assets/frontend/img/${path.label}.png`).attr("class", "route-img");
            const des = route.append("div").attr("class", "route-des");
            des.append("h5").text(path.title);
            des.append("span").text(path.description);
        })
    });
    //Option button to select route i.e. air, road or walk.
    const optionContainer = infoContainer.append("div").attr("class", "infoContainer-footer")
    routeKeys.forEach(function(key, index) {
        const option = optionContainer.append("div").append("img")
        .attr('src', `assets/frontend/img/${key.replace("Route", "-option")}-black.png`)
        .attr("class", "option-img").classed("option-img-selected", index === 0).
        attr("data-label", `${key}`);
        //On mobile view, fix for css media query not working for width and height
        if(isDesktopPage === "none") option.classed("option-img-mobile-edits", true);
    });
    //Change route on respective route option click
    d3.selectAll(".option-img").on("click", function(e){
        d3.selectAll(".route-container").classed("route-container-edits", false);
        d3.select(`div[data-label=${e.target.dataset.label}]`).classed("route-container-edits", true);
        d3.selectAll(".option-img").classed("option-img-selected", false);
        d3.select(this).classed("option-img-selected", true);
    });
    //Get position of route container 
    const {width, height, top} = document.querySelector("div.infoContainer").getBoundingClientRect();
    //Calculate container left position
    let leftPosition = e.clientX - width/2;
    if(leftPosition + width > window.innerWidth) leftPosition = window.innerWidth-width;
    if(leftPosition < 0) leftPosition = 0;
    //Set position according to mouse location
    if(mouseLocation === "topRight") infoContainer.attr("style", `top: ${e.clientY-top+15}px; left: ${leftPosition}px`);
    if(mouseLocation === "topLeft") infoContainer.attr("style", `top: ${e.clientY-top+15}px; left: ${leftPosition}px`);
    if(mouseLocation === "bottomLeft") infoContainer.attr("style", `top: ${e.clientY-top-height-15}px; left: ${leftPosition}px`);
    if(mouseLocation === "bottomRight") infoContainer.attr("style", `top: ${e.clientY-top-height-15}px; left: ${leftPosition}px`);
}

// window.addEventListener("load", async function (event) {
$(document).ready(async function(e){
    //Check displayed map container i.e. mobile or desktop
    const desktopPage =document.querySelector('[data-label="desktop-page"]');
    const isDesktopPage = window.getComputedStyle(desktopPage).getPropertyValue("display");
    const mapId = isDesktopPage === "none" ? "#map-mobile" : "#map";
    const mapContainer = d3.select(mapId);
    //Add loading overlay to container
    $(mapId).LoadingOverlay("show");
    //Load and set svg
    const xml = await d3.xml("assets/frontend/img/map2.svg");
    xml.documentElement.id = "map-svg";
    mapContainer.node().append(xml.documentElement);
    //Remove loading after svg load complete
    $(mapId).LoadingOverlay("hide");
    const svgElement = d3.select("#map-svg");
    mapContainer.style("height", "auto");
    //Highlight junction for
    const junctionPart = ["nep-but", "lum-cir-but"];
    const exclude = ["nep-lum-junc", "lum-gor-junc", "lum-but", "but-label"];
    //Highlight Highways
    svgElement.selectAll(".cls-121, .cls-7, .cls-122").on("mouseover", function (e) {
        // if(this.id === "nep-lum-junc") return;
        if(exclude.includes(this.id)) return;
        if(junctionPart.includes(this.id)){
            d3.select("#nep-lum-junc").classed("highlight-junction", true);
        }
        //Highlight another route if route id matches:
        if(this.id === "pok-but") d3.select("#tan-but").classed("highlight-junction", true);
        if(this.id === "lum-cir-but") d3.selectAll("#lum-but, #nep-lum-junc").classed("highlight-junction", true);
        if(this.id === "lum-sid-but") d3.selectAll("#lum-but, #lum-gor-junc").classed("highlight-junction", true);
        if(this.id === "gor-but") d3.select("#lum-gor-junc").classed("highlight-junction", true);
        d3.select(this).classed("highlight", true);
        //Highlight bus park to base station route for every route
        d3.select("#but-base").classed("highlight-junction", true);
    }).on("mouseleave", function(e) {
        //Remove highlight on mouse remove
        if(junctionPart.includes(this.id)) d3.select("#nep-lum-junc").classed("highlight-junction", false);
        if(this.id === "pok-but") d3.select("#tan-but").classed("highlight-junction", false);
        if(this.id === "lum-cir-but") d3.selectAll("#lum-but, #nep-lum-junc").classed("highlight-junction", false);
        if(this.id === "lum-sid-but") d3.selectAll("#lum-but, #lum-gor-junc").classed("highlight-junction", false);
        if(this.id === "gor-but") d3.select(" #lum-gor-junc").classed("highlight-junction", false);
        d3.select("#but-base").classed("highlight-junction", false);
    })
    //Show route informations
    .on("click", function(e){
        const info = data.find(function(d) {return d.id === e.target.id});
        displayRouteInformation(e, info);
    });
    //Show route information on icons
    svgElement.selectAll("#nepalgunj, #kathmandu, #pokhara, #gorakhpur, #lumbini, #tansen")
    .on("mouseover", function(e){
        d3.select(this).classed("clickable", true);
    }).on("click", function(e){
        const info = data.find(function(d) {return d.location === e.target.id});
        displayRouteInformation(e, info);
    });
});
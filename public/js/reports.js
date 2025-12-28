/**
 * Reports Page JavaScript
 * Handles chart rendering and period filter functionality
 */

document.addEventListener("DOMContentLoaded", function () {
    console.log("Reports JS loaded");

    // ========== GET DATA FROM HTML ELEMENT ==========
    var dataEl = document.getElementById("reportData");

    if (!dataEl) {
        console.error("reportData element not found!");
        return;
    }

    var trendLabels = JSON.parse(dataEl.dataset.trendLabels || "[]");
    var trendSales = JSON.parse(dataEl.dataset.trendSales || "[]");
    var trendExpenses = JSON.parse(dataEl.dataset.trendExpenses || "[]");
    var summaryData = JSON.parse(dataEl.dataset.summary || "[]");
    var netProfit = parseFloat(dataEl.dataset.netProfit) || 0;

    var topFishHasData = dataEl.dataset.topFishHasData === "1";
    var topFishLabels = JSON.parse(dataEl.dataset.topFishLabels || "[]");
    var topFishData = JSON.parse(dataEl.dataset.topFishData || "[]");

    var expenseHasData = dataEl.dataset.expenseHasData === "1";
    var expenseLabels = JSON.parse(dataEl.dataset.expenseLabels || "[]");
    var expenseData = JSON.parse(dataEl.dataset.expenseData || "[]");

    console.log("Data loaded:", { trendLabels, summaryData, netProfit });

    // ========== PERIOD BUTTONS ==========
    var periodBtns = document.querySelectorAll(".period-btn");

    periodBtns.forEach(function (btn) {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            console.log("Period button clicked:", this.dataset.period);

            var period = this.getAttribute("data-period");
            var today = new Date();
            var start, end;

            // Calculate dates based on period
            switch (period) {
                case "today":
                    start = end = formatDate(today);
                    break;
                case "yesterday":
                    var yesterday = new Date(today);
                    yesterday.setDate(yesterday.getDate() - 1);
                    start = end = formatDate(yesterday);
                    break;
                case "week":
                    var day = today.getDay();
                    var diff = today.getDate() - day + (day === 0 ? -6 : 1);
                    var weekStart = new Date(
                        today.getFullYear(),
                        today.getMonth(),
                        diff
                    );
                    var weekEnd = new Date(weekStart);
                    weekEnd.setDate(weekEnd.getDate() + 6);
                    start = formatDate(weekStart);
                    end = formatDate(weekEnd);
                    break;
                case "month":
                    var monthStart = new Date(
                        today.getFullYear(),
                        today.getMonth(),
                        1
                    );
                    var monthEnd = new Date(
                        today.getFullYear(),
                        today.getMonth() + 1,
                        0
                    );
                    start = formatDate(monthStart);
                    end = formatDate(monthEnd);
                    break;
                case "year":
                    start = today.getFullYear() + "-01-01";
                    end = today.getFullYear() + "-12-31";
                    break;
                default:
                    start = end = formatDate(today);
            }

            console.log("Calculated dates:", { start, end });

            // Update form fields
            var startDateEl = document.getElementById("startDate");
            var endDateEl = document.getElementById("endDate");
            var periodInputEl = document.getElementById("periodInput");
            var filterFormEl = document.getElementById("filterForm");

            if (startDateEl) startDateEl.value = start;
            if (endDateEl) endDateEl.value = end;
            if (periodInputEl) periodInputEl.value = period;

            // Submit form
            if (filterFormEl) {
                console.log("Submitting form...");
                filterFormEl.submit();
            }
        });
    });

    // ========== DATE FORMAT HELPER ==========
    function formatDate(date) {
        var year = date.getFullYear();
        var month = String(date.getMonth() + 1).padStart(2, "0");
        var day = String(date.getDate()).padStart(2, "0");
        return year + "-" + month + "-" + day;
    }

    // ========== FORMAT RUPIAH ==========
    function formatRupiah(angka) {
        return "Rp " + angka.toLocaleString("id-ID");
    }

    // ========== CHECK CHART.JS ==========
    if (typeof Chart === "undefined") {
        console.error("Chart.js not loaded!");
        return;
    }

    // ========== CHART.JS GLOBAL CONFIG ==========
    Chart.defaults.font.family = "system-ui, -apple-system, sans-serif";

    // ========== TREND CHART ==========
    var trendCtx = document.getElementById("trendChart");
    if (trendCtx) {
        console.log("Creating trend chart...");
        new Chart(trendCtx.getContext("2d"), {
            type: "line",
            data: {
                labels: trendLabels,
                datasets: [
                    {
                        label: "Penjualan",
                        data: trendSales,
                        borderColor: "rgb(34, 197, 94)",
                        backgroundColor: "rgba(34, 197, 94, 0.1)",
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                    {
                        label: "Pengeluaran",
                        data: trendExpenses,
                        borderColor: "rgb(239, 68, 68)",
                        backgroundColor: "rgba(239, 68, 68, 0.1)",
                        tension: 0.4,
                        fill: true,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    intersect: false,
                    mode: "index",
                },
                plugins: {
                    legend: {
                        position: "top",
                        labels: {
                            usePointStyle: true,
                            padding: 15,
                        },
                    },
                    tooltip: {
                        backgroundColor: "rgba(0, 0, 0, 0.8)",
                        padding: 12,
                        callbacks: {
                            label: function (ctx) {
                                return (
                                    ctx.dataset.label +
                                    ": " +
                                    formatRupiah(ctx.parsed.y)
                                );
                            },
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: "rgba(0, 0, 0, 0.05)" },
                        ticks: {
                            callback: function (v) {
                                return "Rp " + (v / 1000000).toFixed(1) + "jt";
                            },
                        },
                    },
                    x: { grid: { display: false } },
                },
            },
        });
    }

    // ========== SUMMARY CHART ==========
    var summaryCtx = document.getElementById("summaryChart");
    if (summaryCtx) {
        console.log("Creating summary chart...");
        new Chart(summaryCtx.getContext("2d"), {
            type: "bar",
            data: {
                labels: [
                    "Pendapatan",
                    "Biaya Pembelian",
                    "Pengeluaran",
                    "Laba Bersih",
                ],
                datasets: [
                    {
                        data: summaryData,
                        backgroundColor: [
                            "rgba(34, 197, 94, 0.8)",
                            "rgba(251, 146, 60, 0.8)",
                            "rgba(239, 68, 68, 0.8)",
                            netProfit >= 0
                                ? "rgba(59, 130, 246, 0.8)"
                                : "rgba(107, 114, 128, 0.8)",
                        ],
                        borderRadius: 8,
                        borderWidth: 0,
                    },
                ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: "rgba(0, 0, 0, 0.8)",
                        padding: 12,
                        callbacks: {
                            label: function (ctx) {
                                return formatRupiah(ctx.parsed.y);
                            },
                        },
                    },
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: "rgba(0, 0, 0, 0.05)" },
                        ticks: {
                            callback: function (v) {
                                return "Rp " + (v / 1000000).toFixed(1) + "jt";
                            },
                        },
                    },
                    x: { grid: { display: false } },
                },
            },
        });
    }

    // ========== TOP FISH CHART ==========
    if (topFishHasData) {
        var topCtx = document.getElementById("topFishChart");
        if (topCtx) {
            console.log("Creating top fish chart...");
            new Chart(topCtx.getContext("2d"), {
                type: "bar",
                data: {
                    labels: topFishLabels,
                    datasets: [
                        {
                            data: topFishData,
                            backgroundColor: [
                                "rgba(147, 51, 234, 0.8)",
                                "rgba(168, 85, 247, 0.8)",
                                "rgba(192, 132, 252, 0.8)",
                                "rgba(216, 180, 254, 0.8)",
                                "rgba(233, 213, 255, 0.8)",
                            ],
                            borderRadius: 8,
                            borderWidth: 0,
                        },
                    ],
                },
                options: {
                    indexAxis: "y",
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            backgroundColor: "rgba(0, 0, 0, 0.8)",
                            padding: 12,
                            callbacks: {
                                label: function (ctx) {
                                    return formatRupiah(ctx.parsed.x);
                                },
                            },
                        },
                    },
                    scales: {
                        x: {
                            beginAtZero: true,
                            grid: { color: "rgba(0, 0, 0, 0.05)" },
                            ticks: {
                                callback: function (v) {
                                    return (
                                        "Rp " + (v / 1000000).toFixed(1) + "jt"
                                    );
                                },
                            },
                        },
                        y: { grid: { display: false } },
                    },
                },
            });
        }
    }

    // ========== EXPENSE CHART ==========
    if (expenseHasData) {
        var expenseCtx = document.getElementById("expenseChart");
        if (expenseCtx) {
            console.log("Creating expense chart...");
            new Chart(expenseCtx.getContext("2d"), {
                type: "doughnut",
                data: {
                    labels: expenseLabels,
                    datasets: [
                        {
                            data: expenseData,
                            backgroundColor: [
                                "rgba(239, 68, 68, 0.8)",
                                "rgba(251, 146, 60, 0.8)",
                                "rgba(34, 197, 94, 0.8)",
                                "rgba(59, 130, 246, 0.8)",
                                "rgba(147, 51, 234, 0.8)",
                                "rgba(251, 191, 36, 0.8)",
                                "rgba(236, 72, 153, 0.8)",
                                "rgba(20, 184, 166, 0.8)",
                            ],
                            borderWidth: 0,
                            hoverOffset: 10,
                        },
                    ],
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: "60%",
                    plugins: {
                        legend: {
                            position: "bottom",
                            labels: {
                                usePointStyle: true,
                                padding: 15,
                            },
                        },
                        tooltip: {
                            backgroundColor: "rgba(0, 0, 0, 0.8)",
                            padding: 12,
                            callbacks: {
                                label: function (ctx) {
                                    var label = ctx.label || "";
                                    var value = ctx.parsed;
                                    var total = ctx.dataset.data.reduce(
                                        function (a, b) {
                                            return a + b;
                                        },
                                        0
                                    );
                                    var pct = ((value / total) * 100).toFixed(
                                        1
                                    );
                                    return (
                                        label +
                                        ": " +
                                        formatRupiah(value) +
                                        " (" +
                                        pct +
                                        "%)"
                                    );
                                },
                            },
                        },
                    },
                },
            });
        }
    }

    console.log("Reports page initialized successfully!");
});

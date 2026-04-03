<div class="insp-dots-loader" role="status" aria-label="Cargando">
    <span></span><span></span><span></span><span></span><span></span>
</div>
<style>
    .insp-dots-loader { display:flex; align-items:center; justify-content:center; gap:16px; padding:10px 0; }
    .insp-dots-loader span { width:14px; height:14px; border-radius:999px; animation: insp-dot-bounce 1s infinite ease-in-out; }
    .insp-dots-loader span:nth-child(1){ background:#e53935; animation-delay:0s; }
    .insp-dots-loader span:nth-child(2){ background:#1e88e5; animation-delay:.12s; }
    .insp-dots-loader span:nth-child(3){ background:#43a047; animation-delay:.24s; }
    .insp-dots-loader span:nth-child(4){ background:#fdd835; animation-delay:.36s; }
    .insp-dots-loader span:nth-child(5){ background:#fb8c00; animation-delay:.48s; }
    @keyframes insp-dot-bounce {
        0%, 80%, 100% { transform: translateY(0); opacity: .55; }
        40% { transform: translateY(-7px); opacity: 1; }
    }
</style>

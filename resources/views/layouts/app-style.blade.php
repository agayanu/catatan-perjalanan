<style>
    .logout {
        color: #e26666 !important;
    }
    .sidebar-nav .nav-icon {
        flex: 0 0 3rem;
    }
    @media (min-width: 768px){
        .sidebar-fixed.sidebar-narrow-unfoldable:not(:hover), .sidebar-fixed.sidebar-narrow {
            z-index: 1031;
            width: 3rem;
        }
    }
    .sidebar-narrow-unfoldable:not(.sidebar-end) ~ * {
        --cui-sidebar-occupy-start: 3rem;
    }
    @media (max-width: 600px){
        .footer {
            display: block;
        }
        .footer-item {
            text-align: center;
        }
    }
    html:not([dir=rtl]) .wrapper {
        padding-left: var(--cui-sidebar-occupy-start, 0);
    }
</style>
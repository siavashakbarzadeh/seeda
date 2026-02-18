import { useEffect, useRef } from 'react';

/**
 * ScrollReveal — wraps children with an IntersectionObserver
 * to trigger fade-in animations when scrolled into view.
 *
 * @param {string} className - Additional CSS animation class (default: 'fade-in')
 * @param {number} delay - Stagger index (1-6) for staggered animations
 * @param {number} threshold - Visibility threshold (0-1)
 */
export default function ScrollReveal({
    children,
    className = 'fade-in',
    delay = 0,
    threshold = 0.15,
}) {
    const ref = useRef(null);

    useEffect(() => {
        const el = ref.current;
        if (!el) return;

        const observer = new IntersectionObserver(
            ([entry]) => {
                if (entry.isIntersecting) {
                    el.classList.add('visible');
                    observer.unobserve(el);
                }
            },
            { threshold }
        );

        observer.observe(el);
        return () => observer.disconnect();
    }, [threshold]);

    const staggerClass = delay ? `stagger-${delay}` : '';

    return (
        <div ref={ref} className={`${className} ${staggerClass}`}>
            {children}
        </div>
    );
}

import Hero from '../components/home/Hero';
import ServicesPreview from '../components/home/ServicesPreview';
import TrustStrip from '../components/home/TrustStrip';
import FeaturedCaseStudy from '../components/home/FeaturedCaseStudy';
import CtaSection from '../components/home/CtaSection';

export default function HomePage() {
    return (
        <>
            <Hero />
            <ScrollReveal className="zoom-in">
                <ServicesPreview />
            </ScrollReveal>
            <TrustStrip />
            <ScrollReveal className="zoom-in">
                <FeaturedCaseStudy />
            </ScrollReveal>
            <CtaSection />
        </>
    );
}

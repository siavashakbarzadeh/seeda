import Hero from '../components/home/Hero';
import ServicesPreview from '../components/home/ServicesPreview';
import TrustStrip from '../components/home/TrustStrip';
import FeaturedCaseStudy from '../components/home/FeaturedCaseStudy';
import CtaSection from '../components/home/CtaSection';

export default function HomePage() {
    return (
        <>
            <Hero />
            <ServicesPreview />
            <TrustStrip />
            <FeaturedCaseStudy />
            <CtaSection />
        </>
    );
}

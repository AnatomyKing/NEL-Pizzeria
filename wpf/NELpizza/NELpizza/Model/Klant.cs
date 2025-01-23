using System.Collections.Generic;

namespace NELpizza.Model
{
    public class Klant
    {
        public long Id { get; set; }
        public string Naam { get; set; } = string.Empty;
        public string Email { get; set; } = string.Empty;
        public string Telefoon { get; set; } = string.Empty;

        // Navigation property for orders
        public virtual ICollection<Bestelling> Bestellingen { get; set; } = new HashSet<Bestelling>();
    }
}

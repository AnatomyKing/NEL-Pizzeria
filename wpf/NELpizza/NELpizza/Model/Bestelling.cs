using System;
using System.Collections.Generic;
using System.ComponentModel.DataAnnotations;
using System.ComponentModel.DataAnnotations.Schema;

namespace NELpizza.Model
{
    [Table("bestellings")]
    public class Bestelling
    {
        [Key]
        [DatabaseGenerated(DatabaseGeneratedOption.Identity)]
        [Column("id", TypeName = "BIGINT UNSIGNED")]
        public long Id { get; set; }

        [Column("datum", TypeName = "TIMESTAMP")]
        public DateTime Datum { get; set; } = DateTime.UtcNow;

        [Required]
        [Column("status", TypeName = "ENUM('besteld','bereiden','inoven','uitoven','onderweg','bezorgd')")]
        public string Status { get; set; } = "besteld";

        [ForeignKey("Klant")]
        [Column("klant_id", TypeName = "BIGINT UNSIGNED")]
        public long KlantId { get; set; }

        public virtual Klant? Klant { get; set; }
        public virtual ICollection<Bestelregel> Bestelregels { get; set; } = new HashSet<Bestelregel>();
    }
}
